package org.joda.time;


import org.joda.time.tz.*;

import java.io.File;
import java.util.Set;
import java.util.TimeZone;
import java.util.concurrent.atomic.AtomicReference;

import static org.joda.time.DateTimeZone.forID;
import static org.joda.time.DateTimeZone.forTimeZone;

public class DateTimeZoneProvider {

    public static final DateTimeZone UTC = UTCDateTimeZone.INSTANCE;

    private static final AtomicReference<Provider> cProvider =
            new AtomicReference<Provider>();

    private static final AtomicReference<NameProvider> cName =
            new AtomicReference<NameProvider>();

    private static final AtomicReference<DateTimeZone> cDefault =
            new AtomicReference<DateTimeZone>();

    private static NameProvider getDefaultNameProvider() {
        NameProvider nameProvider = null;
        try {
            String providerClass = System.getProperty("org.joda.time.DateTimeZone.NameProvider");
            if (providerClass != null) {
                try {
                    nameProvider = (NameProvider) Class.forName(providerClass).newInstance();
                } catch (Exception ex) {
                    throw new RuntimeException(ex);
                }
            }
        } catch (SecurityException ex) {
            // ignore
        }

        if (nameProvider == null) {
            nameProvider = new DefaultNameProvider();
        }

        return nameProvider;
    }

    private static Provider getDefaultProvider() {
        // approach 1
        try {
            String providerClass = System.getProperty("org.joda.time.DateTimeZone.Provider");
            if (providerClass != null) {
                try {
                    Provider provider = (Provider) Class.forName(providerClass).newInstance();
                    return validateProvider(provider);
                } catch (Exception ex) {
                    throw new RuntimeException(ex);
                }
            }
        } catch (SecurityException ex) {
            // ignored
        }
        // approach 2
        try {
            String dataFolder = System.getProperty("org.joda.time.DateTimeZone.Folder");
            if (dataFolder != null) {
                try {
                    Provider provider = new ZoneInfoProvider(new File(dataFolder));
                    return validateProvider(provider);
                } catch (Exception ex) {
                    throw new RuntimeException(ex);
                }
            }
        } catch (SecurityException ex) {
            // ignored
        }
        // approach 3
        try {
            Provider provider = new ZoneInfoProvider("org/joda/time/tz/data");
            return validateProvider(provider);
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        // approach 4
        return new UTCProvider();
    }

    private static Provider validateProvider(Provider provider) {
        Set<String> ids = provider.getAvailableIDs();
        checkIDs(ids);
        checkUTCSupport(ids);
        checkUTCZone(provider);
        return provider;
    }

    private static void checkUTCZone(Provider provider) {
        if (!UTC.equals(provider.getZone("UTC"))) {
            throw new IllegalArgumentException("Invalid UTC zone provided");
        }
    }

    private static void checkUTCSupport(Set<String> ids) {
        if (!ids.contains("UTC")) {
            throw new IllegalArgumentException("The provider doesn't support UTC");
        }
    }

    private static void checkIDs(Set<String> ids) {
        if (ids == null || ids.size() == 0) {
            throw new IllegalArgumentException("The provider doesn't have any available ids");
        }
    }

    public DateTimeZone byDefault() {

        DateTimeZone zone = cDefault.get();

        if (isNull(zone)) {
            zone = obtainForId();
        }
        if (isNull(zone)) {
            zone = obtainForTimeZone();
        }
        if (isNull(zone)) {
            zone = UTC;
        }

        return updateZone(zone);
    }

    private DateTimeZone updateZone(DateTimeZone zone) {
        if (!cDefault.compareAndSet(null, zone)) {
            zone = cDefault.get();
        }
        return zone;
    }

    private DateTimeZone obtainForTimeZone() {
        DateTimeZone zone = null;
        try {
            zone = forTimeZone(TimeZone.getDefault());
        } catch (IllegalArgumentException ex) {
            // ignored
        }
        return zone;
    }

    private boolean isNull(Object value) {
        return value == null;
    }

    private DateTimeZone obtainForId() {
        DateTimeZone zone = null;
        String id = System.getProperty("user.timezone");
        if (!isNull(id)) {
            try {
                zone = forID(id);
            } catch (RuntimeException ex) {
                // ignored
            }
        }
        return zone;
    }

    public void setByDefault(DateTimeZone zone) {
        checkPermission("DateTimeZone.setDefault");
        checkNull(zone);
        cDefault.set(zone);
    }

    private void checkNull(DateTimeZone zone) {
        if (isNull(zone)) {
            throw new IllegalArgumentException("The datetime zone must not be null");
        }
    }

    private void checkPermission(String name) {
        SecurityManager sm = System.getSecurityManager();
        if (sm != null) {
            sm.checkPermission(new JodaTimePermission(name));
        }
    }

    public NameProvider name() {
        NameProvider nameProvider = cName.get();
        if (isNull(nameProvider)) {
            nameProvider = updateName(getDefaultNameProvider());
        }
        return nameProvider;
    }

    private NameProvider updateName(NameProvider nameProvider) {
        if (!cName.compareAndSet(null, nameProvider)) {
            nameProvider = cName.get();
        }
        return nameProvider;
    }

    public void setName(NameProvider name) {
        checkPermission("DateTimeZone.setNameProvider");

        if (isNull(name)) {
            name = getDefaultNameProvider();
        }
        cName.set(name);
    }

    public void setProvider(Provider provider) {
        checkPermission("DateTimeZone.setProvider");

        if (isNull(provider)) {
            provider = getDefaultProvider();
        } else {
            validateProvider(provider);
        }
        cProvider.set(provider);
    }

    public Provider provider() {
        Provider provider = cProvider.get();
        if (isNull(provider)) {
            provider = updateProvider(getDefaultProvider());
        }
        return provider;
    }

    private Provider updateProvider(Provider provider) {
        if (!cProvider.compareAndSet(null, provider)) {
            provider = cProvider.get();
        }
        return provider;
    }
}


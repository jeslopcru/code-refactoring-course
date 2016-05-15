package org.joda.time;


import org.joda.time.tz.NameProvider;
import org.joda.time.tz.Provider;

import java.util.TimeZone;
import java.util.concurrent.atomic.AtomicReference;

import static org.joda.time.DateTimeZone.forID;
import static org.joda.time.DateTimeZone.forTimeZone;

public class DateTimeZoneProvider {

    public static final DateTimeZone UTC = UTCDateTimeZone.INSTANCE;

    private static final AtomicReference<Provider> cProvider =
            new AtomicReference<Provider>();

    private static final AtomicReference<NameProvider> cNameProvider =
            new AtomicReference<NameProvider>();

    private static final AtomicReference<DateTimeZone> cDefault =
            new AtomicReference<DateTimeZone>();


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
        zone = updateZone(zone);

        return zone;
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

    private boolean isNull(DateTimeZone zone) {
        return zone == null;
    }

    private DateTimeZone obtainForId() {
        DateTimeZone zone = null;
        String id = System.getProperty("user.timezone");
        if (id != null) {  // null check avoids stack overflow
            try {
                zone = forID(id);
            } catch (RuntimeException ex) {
                // ignored
            }
        }
        return zone;
    }

    public void setByDefault(DateTimeZone zone) {
        checkPermission();
        checkNull(zone);
        cDefault.set(zone);
    }

    private void checkNull(DateTimeZone zone) {
        if (isNull(zone)) {
            throw new IllegalArgumentException("The datetime zone must not be null");
        }
    }

    private void checkPermission() {
        SecurityManager sm = System.getSecurityManager();
        if (sm != null) {
            sm.checkPermission(new JodaTimePermission("DateTimeZone.setDefault"));
        }
    }
}

package org.joda.time;

import java.util.HashMap;

public class Pool {

    private static Pool myInstance;
    private HashMap<Integer, Days> days;
    private HashMap<Integer, Hours> hours;
    private HashMap<Integer, Minutes> minutes;

    private Pool() {
        this.days = new HashMap<Integer, Days>();
        this.hours = new HashMap<Integer, Hours>();
        this.minutes = new HashMap<Integer, Minutes>();

    }

    public static Pool getInstance() {

        if (myInstance == null) {
            myInstance = new Pool();
        }

        return myInstance;
    }

    public static Days retrieveDays(int numeral) {
        Pool pool = Pool.getInstance();

        Days result = pool.getDays(numeral);

        if (result == null) {
            result = new Days(numeral);
            pool.addDay(numeral, result);
        }

        return result;
    }

    public static Minutes retrieveMinutes(int numeral) {

        Pool pool = Pool.getInstance();

        Minutes result = pool.getMinutes(numeral);

        if (result == null) {
            result = new Minutes(numeral);
            pool.addMinutes(numeral, result);
        }

        return result;
    }

    public static Hours retrieveHours(int i) {
        Pool pool = Pool.getInstance();

        Hours result = pool.getHours(i);

        if (result == null) {
            result = new Hours(i);
            pool.addHours(i, result);
        }
        return result;
    }

    private void addDay(int numeral, Days day) {
        days.put(numeral, day);
    }

    private void addHours(int i, Hours result) {
        hours.put(i, result);
    }

    private void addMinutes(int numeral, Minutes minute) {
        minutes.put(numeral, minute);
    }

    private Days getDays(int numeral) {
        return days.get(numeral);
    }

    private Hours getHours(int i) {
        return hours.get(i);
    }

    private Minutes getMinutes(int numeral) {
        return minutes.get(numeral);
    }
}

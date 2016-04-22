package org.joda.time;

import java.util.HashMap;

public class Pool {

    private static Pool myInstance;
    private HashMap<Integer, Days> days;
    private HashMap<Integer, Hours> hours;
    private HashMap<Integer, Minutes> minutes;
    private HashMap<Integer, Months> months;
    private HashMap<Integer, Seconds> seconds;

    private Pool() {
        this.days = new HashMap<Integer, Days>();
        this.hours = new HashMap<Integer, Hours>();
        this.minutes = new HashMap<Integer, Minutes>();
        this.months = new HashMap<Integer, Months>();
        this.seconds = new HashMap<Integer, Seconds>();
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

    public static Months retrieveMonths(int i) {
        Pool pool = Pool.getInstance();

        Months result = pool.getMonths(i);

        if (result == null) {
            result = new Months(i);
            pool.addMonths(i, result);
        }
        return result;
    }

    public static Seconds retrieveSeconds(int i) {
        Pool pool = Pool.getInstance();

        Seconds result = pool.getSeconds(i);

        if (result == null) {
            result = new Seconds(i);
            pool.addSeconds(i, result);
        }
        return result;
    }

    private void addSeconds(int i, Seconds result) {
        seconds.put(i,result);
    }

    private Seconds getSeconds(int i) {
        return seconds.get(i);
    }

    private void addDay(int numeral, Days day) {
        days.put(numeral, day);
    }

    private Days getDays(int numeral) {
        return days.get(numeral);
    }

    private void addHours(int i, Hours result) {
        hours.put(i, result);
    }

    private Hours getHours(int i) {
        return hours.get(i);
    }

    private void addMinutes(int numeral, Minutes minute) {
        minutes.put(numeral, minute);
    }

    private Minutes getMinutes(int numeral) {
        return minutes.get(numeral);
    }

    private void addMonths(int i, Months months) {
        this.months.put(i, months);
    }

    private Months getMonths(int i) {
        return months.get(i);
    }
}

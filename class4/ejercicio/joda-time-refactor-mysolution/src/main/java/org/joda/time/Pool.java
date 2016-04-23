package org.joda.time;

import java.util.HashMap;

class Pool {

    private static Pool myInstance;
    private DaysPool days;
    private HoursPool hours;
    private HashMap<Integer, Minutes> minutes;
    private HashMap<Integer, Months> months;
    private HashMap<Integer, Seconds> seconds;
    private HashMap<Integer, Weeks> weeks;
    private HashMap<Integer, Years> years;


    private Pool() {
        this.days = new DaysPool();
        this.hours = new HoursPool();
        this.minutes = new HashMap<Integer, Minutes>();
        this.months = new HashMap<Integer, Months>();
        this.seconds = new HashMap<Integer, Seconds>();
        this.weeks = new HashMap<Integer, Weeks>();
        this.years = new HashMap<Integer, Years>();
    }

    public static Pool getInstance() {

        if (myInstance == null) {
            myInstance = new Pool();
        }

        return myInstance;
    }

    static Days retrieveDays(int numeral) {
        Pool pool = Pool.getInstance();
        return pool.days.retrieveDays(numeral);
    }

    static Hours retrieveHours(int numeral) {
        Pool pool = Pool.getInstance();
        return pool.hours.retrieveHours(numeral);
    }

    static Minutes retrieveMinutes(int numeral) {

        Pool pool = Pool.getInstance();

        Minutes result = pool.getMinutes(numeral);

        if (result == null) {
            result = new Minutes(numeral);
            pool.addMinutes(numeral, result);
        }

        return result;
    }

    static Months retrieveMonths(int numeral) {
        Pool pool = Pool.getInstance();

        Months result = pool.getMonths(numeral);

        if (result == null) {
            result = new Months(numeral);
            pool.addMonths(numeral, result);
        }
        return result;
    }

    static Seconds retrieveSeconds(int numeral) {
        Pool pool = Pool.getInstance();

        Seconds result = pool.getSeconds(numeral);

        if (result == null) {
            result = new Seconds(numeral);
            pool.addSeconds(numeral, result);
        }
        return result;
    }

    static Weeks retrieveWeeks(int numeral) {
        Pool pool = Pool.getInstance();

        Weeks result = pool.getWeeks(numeral);

        if (result == null) {
            result = new Weeks(numeral);
            pool.addWeeks(numeral, result);
        }
        return result;
    }

    static Years retrieveYears(int numeral) {
        Pool pool = Pool.getInstance();

        Years result = pool.getYears(numeral);

        if (result == null) {
            result = new Years(numeral);
            pool.addYears(numeral, result);
        }
        return result;
    }

    private void addYears(int numeral, Years years) {
        this.years.put(numeral, years);
    }

    private Years getYears(int numeral) {
        return years.get(numeral);
    }

    private void addWeeks(int numeral, Weeks week) {
        this.weeks.put(numeral, week);
    }

    private Weeks getWeeks(int numeral) {
        return weeks.get(numeral);
    }

    private void addSeconds(int numeral, Seconds second) {
        this.seconds.put(numeral, second);
    }

    private Seconds getSeconds(int numeral) {
        return seconds.get(numeral);
    }

    private void addMinutes(int numeral, Minutes minute) {
        minutes.put(numeral, minute);
    }

    private Minutes getMinutes(int numeral) {
        return minutes.get(numeral);
    }

    private void addMonths(int numeral, Months month) {
        this.months.put(numeral, month);
    }

    private Months getMonths(int numeral) {
        return months.get(numeral);
    }

}

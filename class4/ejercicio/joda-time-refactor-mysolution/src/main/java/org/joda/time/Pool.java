package org.joda.time;

import java.util.HashMap;

class Pool {

    private static Pool myInstance;
    private DaysPool days;
    private HoursPool hours;
    private MinutesPool minutes;
    private MonthsPool months;
    private SecondsPool seconds;
    private HashMap<Integer, Weeks> weeks;
    private HashMap<Integer, Years> years;


    private Pool() {
        this.days = new DaysPool();
        this.hours = new HoursPool();
        this.minutes = new MinutesPool();
        this.months = new MonthsPool();
        this.seconds = new SecondsPool();
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
        return pool.minutes.retrieveMinutes(numeral);
    }

    static Months retrieveMonths(int numeral) {
        Pool pool = Pool.getInstance();
        return pool.months.retrieveMonths(numeral);
    }

    static Seconds retrieveSeconds(int numeral) {
        Pool pool = Pool.getInstance();
        return pool.seconds.retrieveSeconds(numeral);
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
}

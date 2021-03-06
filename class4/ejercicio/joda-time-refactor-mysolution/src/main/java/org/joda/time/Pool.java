package org.joda.time;

class Pool {

    private static Pool myInstance;
    private DaysPool days;
    private HoursPool hours;
    private MinutesPool minutes;
    private MonthsPool months;
    private SecondsPool seconds;
    private WeeksPool weeks;
    private YearsPool years;


    private Pool() {
        this.days = new DaysPool();
        this.hours = new HoursPool();
        this.minutes = new MinutesPool();
        this.months = new MonthsPool();
        this.seconds = new SecondsPool();
        this.weeks = new WeeksPool();
        this.years = new YearsPool();
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
        return pool.weeks.retrieveWeeks(numeral);
    }

    static Years retrieveYears(int numeral) {
        Pool pool = Pool.getInstance();
        return pool.years.retrieveYears(numeral);
    }
}

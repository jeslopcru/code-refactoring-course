package org.joda.time;

import java.util.HashMap;

class MonthsPool {

    private HashMap<Integer, Months> months;

    MonthsPool() {
        this.months = new HashMap<Integer, Months>();
    }

    Months retrieveMonths(int numeral) {

        Months result = getMonths(numeral);

        if (result == null) {
            result = new Months(numeral);
            addMonths(numeral, result);
        }
        return result;
    }

    private void addMonths(int numeral, Months month) {
        this.months.put(numeral, month);
    }

    private Months getMonths(int numeral) {
        return months.get(numeral);
    }
}

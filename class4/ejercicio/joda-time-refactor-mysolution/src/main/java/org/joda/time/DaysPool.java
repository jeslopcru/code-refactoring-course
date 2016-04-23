package org.joda.time;

import java.util.HashMap;

public class DaysPool {

    private HashMap<Integer, Days> days;

    protected DaysPool() {
        this.days = new HashMap<Integer, Days>();
    }

    private void addDay(int numeral, Days day) {
        days.put(numeral, day);
    }

    private Days getDays(int numeral) {
        return days.get(numeral);
    }

    protected Days retrieveDays(int numeral) {

        Days result = this.getDays(numeral);

        if (result == null) {
            result = new Days(numeral);
            this.addDay(numeral, result);
        }

        return result;
    }

}

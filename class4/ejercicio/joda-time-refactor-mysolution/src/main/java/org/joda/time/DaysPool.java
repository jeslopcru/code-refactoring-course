package org.joda.time;

import java.util.HashMap;

class DaysPool {

    private HashMap<Integer, Days> days;

    DaysPool() {
        this.days = new HashMap<Integer, Days>();
    }

    private void addDay(int numeral, Days day) {
        days.put(numeral, day);
    }

    private Days getDays(int numeral) {
        return days.get(numeral);
    }

    Days retrieveDays(int numeral) {

        Days result = getDays(numeral);

        if (result == null) {
            result = new Days(numeral);
            addDay(numeral, result);
        }

        return result;
    }

}

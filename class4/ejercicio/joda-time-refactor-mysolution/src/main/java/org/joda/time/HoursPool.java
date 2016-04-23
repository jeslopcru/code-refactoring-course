package org.joda.time;

import java.util.HashMap;

class HoursPool {

    private HashMap<Integer, Hours> hours;

    HoursPool() {
        this.hours = new HashMap<Integer, Hours>();
    }

    Hours retrieveHours(int numeral) {

        Hours result = getHours(numeral);

        if (result == null) {
            result = new Hours(numeral);
            addHours(numeral, result);
        }
        return result;
    }
    private void addHours(int numeral, Hours hour) {
        hours.put(numeral, hour);
    }

    private Hours getHours(int numeral) {
        return hours.get(numeral);
    }

}

package org.joda.time;

import java.util.HashMap;

class MinutesPool {

    private HashMap<Integer, Minutes> minutes;

    MinutesPool() {
        minutes = new HashMap<Integer, Minutes>();
    }

    Minutes retrieveMinutes(int numeral) {

        Minutes result = this.getMinutes(numeral);

        if (result == null) {
            result = new Minutes(numeral);
            this.addMinutes(numeral, result);
        }

        return result;
    }

    private void addMinutes(int numeral, Minutes minute) {
        minutes.put(numeral, minute);
    }

    private Minutes getMinutes(int numeral) {
        return minutes.get(numeral);
    }

}

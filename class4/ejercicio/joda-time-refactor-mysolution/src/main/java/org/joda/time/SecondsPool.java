package org.joda.time;


import java.util.HashMap;

class SecondsPool {

    private HashMap<Integer, Seconds> seconds;

    SecondsPool() {
        seconds = new HashMap<Integer, Seconds>();
    }

    Seconds retrieveSeconds(int numeral) {

        Seconds result = getSeconds(numeral);

        if (result == null) {
            result = new Seconds(numeral);
            addSeconds(numeral, result);
        }
        return result;
    }

    private void addSeconds(int numeral, Seconds second) {
        seconds.put(numeral, second);
    }

    private Seconds getSeconds(int numeral) {
        return seconds.get(numeral);
    }
}

package org.joda.time;

import java.util.HashMap;

class YearsPool {

    private HashMap<Integer, Years> years;

    YearsPool() {
        years = new HashMap<Integer, Years>();
    }

    Years retrieveYears(int numeral) {

        Years result = getYears(numeral);

        if (result == null) {
            result = new Years(numeral);
            addYears(numeral, result);
        }
        return result;
    }

    private void addYears(int numeral, Years years) {
        this.years.put(numeral, years);
    }

    private Years getYears(int numeral) {
        return years.get(numeral);
    }

}

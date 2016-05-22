'use strict';

var util = require('../util/index'),
    Unit = require('./Unit'),
    isNumber = util.number.isNumber;

function ComplexBuilderNumbers() {

}


ComplexBuilderNumbers.construct = function (theArguments) {
    var real = theArguments[0];
    var imaginary = theArguments[1];
    ComplexBuilderNumbers._checkBothNumbers(real, imaginary);

    return {re: real, im: imaginary};
}
ComplexBuilderNumbers._checkBothNumbers = function (aNumber, anotherNumber) {
    if (!isNumber(aNumber) || !isNumber(anotherNumber)) {
        throw new TypeError('Two numbers expected in Complex constructor');
    }
}
module.exports = ComplexBuilderNumbers;
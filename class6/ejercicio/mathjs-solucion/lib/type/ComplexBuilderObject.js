'use strict'

var util = require('../util/index'),
    Unit = require('./Unit'),
    isNumber = util.number.isNumber,
    isUnit = Unit.isUnit;

function ComplexBuilderObject() {

}


ComplexBuilderObject.construct = function (theArguments) {

    var arg = theArguments[0];
    ComplexBuilderObject._checkIsObject(arg);
    var construct;

    if (ComplexBuilderObject._hasBinomialParameters(arg)) {
        construct = {re: arg.re, im: arg.im}; // pass on input validation

    } else {
        construct = ComplexBuilderObject.fromPolar(arg.r, arg.phi);
    }

    return construct;
};

ComplexBuilderObject._checkIsObject = function (subject) {
    var isRightType = (typeof subject === 'object');
    var hasBinomialParameters = ComplexBuilderObject._hasBinomialParameters(subject);
    var hasPolarParameters = ComplexBuilderObject._hasPolarParameters(subject);

    if ((!isRightType || !(hasBinomialParameters || hasPolarParameters))) {
        throw new SyntaxError('Object with the re and im or r and phi properties expected.');
    }
}

ComplexBuilderObject.fromPolar = function (args) {
    switch (arguments.length) {
        case 1:
            var arg = arguments[0];
            if (typeof arg === 'object') {
                return ComplexBuilderObject.fromPolar(arg.r, arg.phi);
            }
            throw new TypeError('Input has to be an object with r and phi keys.');

        case 2:
            var r = arguments[0],
                phi = arguments[1];
            if (isNumber(r)) {
                if (isUnit(phi) && phi.hasBase(Unit.BASE_UNITS.ANGLE)) {
                    // convert unit to a number in radians
                    phi = phi.toNumber('rad');
                }

                if (isNumber(phi)) {
                    return {re: r * Math.cos(phi), im: r * Math.sin(phi)};

                }

                throw new TypeError('Phi is not a number nor an angle unit.');
            } else {
                throw new TypeError('Radius r is not a number.');
            }

        default:
            throw new SyntaxError('Wrong number of arguments in function fromPolar');
    }
};

ComplexBuilderObject._hasBinomialParameters = function (subject) {
    return ('re' in subject && 'im' in subject);
};

ComplexBuilderObject._hasPolarParameters = function (subject) {
    return ('r' in subject && 'phi' in subject);
}

module.exports = ComplexBuilderObject;
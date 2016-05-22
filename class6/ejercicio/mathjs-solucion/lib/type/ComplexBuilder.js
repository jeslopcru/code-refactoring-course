'use strict'

var ComplexBuilderZero = require('./ComplexBuilderZero'),
    ComplexBuilderObject = require('./ComplexBuilderObject'),
    ComplexBuilderNumbers = require('./ComplexBuilderNumbers');

function ComplexBuilder() {

}
var constructorMap = [];
constructorMap[0] =  ComplexBuilderZero;
constructorMap[1] =  ComplexBuilderObject;
constructorMap[2] =  ComplexBuilderNumbers;

ComplexBuilder.construct = function (theArguments) {

    ComplexBuilder._checkArguments(theArguments);

    return constructorMap[theArguments.length].construct(theArguments);
};

ComplexBuilder._checkArguments = function (theArguments) {
    if (theArguments.length > 2) {
        throw new SyntaxError('One, two or three arguments expected in Complex constructor');
    }
}

module.exports = ComplexBuilder;
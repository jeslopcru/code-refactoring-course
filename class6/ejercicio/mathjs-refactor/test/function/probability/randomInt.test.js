var assert = require('assert'),
    math = require('../../../index');

describe('randomInt', function () {
  // Note: randomInt is a convenience function generated by distribution
  // it is tested in distribution.test.js

  it('should have a function randomInt', function () {
    assert.equal(typeof math.randomInt, 'function');
  })
});

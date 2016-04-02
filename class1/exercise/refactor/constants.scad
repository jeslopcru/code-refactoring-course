HEIGHT_NIPPLE = 0.8;

HEIGHT_BODY = 44.5;

GREY = "LightGrey";

FINE = 100;
CONVEXITY = 10;

function radius(diameter) = diameter / 2;

module body(position,height, diameter)
{
    color(GREY)
    translate(position)
        cylinder(
            h = height,
            d = diameter,
            $fn = FINE);    
}
DIAMETER_BASE = 6;
BORDER_RADIUS_BASE = 0.3;

HEIGHT_BODY = 44.5;
GREY = "LightGrey";

module base()
{
   //Base cylinder
color(GREY)
translate([0,0,-(HEIGHT_BODY + BORDER_RADIUS_BASE)])
    cylinder(
        h = BORDER_RADIUS_BASE, 
        d = (DIAMETER_BASE - (2 * BORDER_RADIUS_BASE)),
        $fn = 100);

//Base shoulder
color(GREY)
translate([0,0,-(HEIGHT_BODY)])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BASE/2)-BORDER_RADIUS_BASE, 0, 0])
        circle(r = BORDER_RADIUS_BASE, $fn = 100);

}
base();
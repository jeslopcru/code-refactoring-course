include <constants.scad>;
HEIGHT_BODY = 44.5;
DIAMETER_BODY = 10.4;
BORDER_RADIUS_BODY = 0.2;
HEIGHT_NIPPLE = 0.8;


module body()
{ 
//Top face of main body
translate([0,0,-(HEIGHT_NIPPLE + BORDER_RADIUS_BODY)])
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = (DIAMETER_BODY - (2 * BORDER_RADIUS_BODY)),
        $fn = FINE);
        
//Body top shoulder
translate([0,0,-(HEIGHT_NIPPLE + BORDER_RADIUS_BODY)])
    rotate_extrude(convexity = CONVEXITY, $fn = FINE)
    translate([(DIAMETER_BODY/2)-BORDER_RADIUS_BODY, 0, 0])
        circle(r = BORDER_RADIUS_BODY, $fn = FINE);

//Main body cylinder
translate([0,0,-(HEIGHT_BODY - BORDER_RADIUS_BODY)])
    cylinder(
        h = (HEIGHT_BODY - (HEIGHT_NIPPLE + (2* BORDER_RADIUS_BODY))),
        d = DIAMETER_BODY,
        $fn = FINE);
        
//Body bottom shoulder
translate([0,0,-(HEIGHT_BODY - BORDER_RADIUS_BODY)])
    rotate_extrude(convexity = CONVEXITY, $fn = FINE)
    translate([(DIAMETER_BODY/2)-BORDER_RADIUS_BODY, 0, 0])
        circle(r = BORDER_RADIUS_BODY, $fn = FINE);
        
//Bottom face of body
translate([0,0,-(HEIGHT_BODY)])
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = (DIAMETER_BODY - (2 * BORDER_RADIUS_BODY)),
        $fn = FINE);
}

body();
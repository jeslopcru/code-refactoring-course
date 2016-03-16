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
        $fn = 100);
        
//Body top shoulder
translate([0,0,-(HEIGHT_NIPPLE + BORDER_RADIUS_BODY)])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BODY/2)-BORDER_RADIUS_BODY, 0, 0])
        circle(r = BORDER_RADIUS_BODY, $fn = 100);

//Main body cylinder
translate([0,0,-(HEIGHT_BODY - BORDER_RADIUS_BODY)])
    cylinder(
        h = (HEIGHT_BODY - (HEIGHT_NIPPLE + (2* BORDER_RADIUS_BODY))),
        d = DIAMETER_BODY,
        $fn = 100);
        
//Body bottom shoulder
translate([0,0,-(HEIGHT_BODY - BORDER_RADIUS_BODY)])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BODY/2)-BORDER_RADIUS_BODY, 0, 0])
        circle(r = BORDER_RADIUS_BODY, $fn = 100);
        
//Bottom face of body
translate([0,0,-(HEIGHT_BODY)])
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = (DIAMETER_BODY - (2 * BORDER_RADIUS_BODY)),
        $fn = 100);
}

body();
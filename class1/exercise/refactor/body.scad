include <constants.scad>;
HEIGHT_BODY = 44.5;
DIAMETER_BODY = 10.4;
BORDER_RADIUS_BODY = 0.2;
HEIGHT_NIPPLE = 0.8;

module top_surface()
{
    position_z = -(HEIGHT_NIPPLE + BORDER_RADIUS_BODY);
    position = [0,0,position_z];
    
    correction_diameter = (2 * BORDER_RADIUS_BODY);
    diameter_base = DIAMETER_BODY - correction_diameter;

    translate(position)
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = diameter_base,
        $fn = FINE);
}

module top_shoulder()
{
    position_ring_z = -(HEIGHT_NIPPLE + BORDER_RADIUS_BODY);
    position_ring = [0,0,position_ring_z];
    
    position_circle_x = radius(DIAMETER_BODY)-BORDER_RADIUS_BODY;
    position_circle = [position_circle_x, 0, 0];
    
    translate(position_ring)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
            translate(position_circle)
                circle(r = BORDER_RADIUS_BODY, $fn = FINE); 
}


module body()
{ 
    top_surface();
    top_shoulder();
        
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
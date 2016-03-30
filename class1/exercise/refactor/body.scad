include <constants.scad>;
HEIGHT_BODY = 44.5;
DIAMETER_BODY = 10.4;
BORDER_RADIUS_BODY = 0.2;
HEIGHT_NIPPLE = 0.8;

function top_position_z () = -(HEIGHT_NIPPLE + BORDER_RADIUS_BODY);
function main_position_z() = -(HEIGHT_BODY - BORDER_RADIUS_BODY);
module top_surface()
{
    position = [0,0,top_position_z()];
    
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
    position_ring = [0,0,top_position_z()];
    
    position_circle_x = radius(DIAMETER_BODY)-BORDER_RADIUS_BODY;
    position_circle = [position_circle_x, 0, 0];
    
    translate(position_ring)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
            translate(position_circle)
                circle(r = BORDER_RADIUS_BODY, $fn = FINE); 
}

module main_cylinder()
{
    position = [0,0,main_position_z()];
    translate(position)
        cylinder(
            h = (HEIGHT_BODY - (HEIGHT_NIPPLE + (2*BORDER_RADIUS_BODY))),
            d = DIAMETER_BODY,
            $fn = FINE);
}


module body()
{ 
    top_surface();
    top_shoulder();
    main_cylinder();
        
      
//Body bottom shoulder
translate([0,0,main_position_z()])
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
include <constants.scad>;
HEIGHT_BODY = 44.5;
DIAMETER_BODY = 10.4;
BORDER_RADIUS_BODY = 0.2;
HEIGHT_NIPPLE = 0.8;
HEIGHT_COVER = 2 * BORDER_RADIUS_BODY;


function top_position_z () = -(HEIGHT_NIPPLE + BORDER_RADIUS_BODY);
function main_position_z() = -(HEIGHT_BODY - BORDER_RADIUS_BODY);

module surface(position_z)
{
    position = [0,0,position_z];
    diameter_base = DIAMETER_BODY - HEIGHT_COVER;
    
    translate(position)
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = diameter_base,
        $fn = FINE);
}

module shoulder(position_z)
{
    position_ring = [0,0,position_z];
    
    position_circle_x = radius(DIAMETER_BODY)-BORDER_RADIUS_BODY;
    posision_circle = [position_circle_x, 0, 0];

    translate(position_ring)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
            translate(posision_circle)
                circle(r = BORDER_RADIUS_BODY, $fn = FINE); 
}

module central()
{    
    position = [0,0,main_position_z()];
    
    heigh_main = HEIGHT_BODY - (HEIGHT_NIPPLE + HEIGHT_COVER);

    translate(position)
        cylinder(
            h = heigh_main,
            d = DIAMETER_BODY,
            $fn = FINE);
}


module top()
{
    top_position_z = top_position_z();
    
    surface(top_position_z);
    shoulder(top_position_z); 
}

module bottom()
{
    surface(-HEIGHT_BODY);
    shoulder(main_position_z()); 
}

module body()
{ 
    top();
    central();
    bottom();
}

body();
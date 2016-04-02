include <constants.scad>;
HEIGHT_NIPPLE = 0.8;
DIAMETER_NIPPLE = 3;
BORDER_NIPPLE = 0.2;
DIAMETER_BASE_NIPPLE = 6;

module top_little()
{
    color(GREY)
        translate([0,0,-BORDER_NIPPLE])
            cylinder(
                h = BORDER_NIPPLE, 
                d = (DIAMETER_NIPPLE - (2 * BORDER_NIPPLE)),
                $fn = FINE);
}

module shoulder_top_little()
{
    position_ring = [0,0,-BORDER_NIPPLE];
    
    posicion_circle_x = radius(DIAMETER_NIPPLE)-BORDER_NIPPLE;
    position_circle = [posicion_circle_x, 0, 0];
    
    color(GREY)
    translate(position_ring)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
        translate(position_circle)
        circle(r = BORDER_NIPPLE, $fn = FINE);  
}

module body_central_little()
{
    position_z = BORDER_NIPPLE - HEIGHT_NIPPLE;
    position = [0,0,position_z];
    
    height = HEIGHT_NIPPLE - (BORDER_NIPPLE + BORDER_NIPPLE);
    
    color(GREY)
    translate(position)
        cylinder(
            h = height,
            d = DIAMETER_NIPPLE,
            $fn = FINE);    
}

module milling_nipple()
{
    position_nipple_z = BORDER_NIPPLE - HEIGHT_NIPPLE;
    position_nipple = [0, 0, position_nipple_z];
    position_nipple_border = [radius(DIAMETER_NIPPLE), 0, 0];
        
    translate(position_nipple)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
            translate(position_nipple_border)
                square(BORDER_NIPPLE,BORDER_NIPPLE);
        
}

module milling_base()
{
    position_nipple_z = (2 * BORDER_NIPPLE) - HEIGHT_NIPPLE;
    position_nipple = [0, 0, position_nipple_z];
        
    position_border_x = radius(DIAMETER_NIPPLE) + BORDER_NIPPLE;
    position_border = [position_border_x, 0, 0];
    translate(position_nipple)
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
            translate(position_border)
                circle(r = BORDER_NIPPLE, $fn = FINE);    
}
module milling_nipple_base()
{
    color(GREY)
    difference()
    {
        milling_nipple();
        milling_base();
    }
}

module base_cylinder()
{
    position_z = -HEIGHT_NIPPLE;
    position = [0, 0, position_z];
    diameter = DIAMETER_BASE_NIPPLE - (2 * BORDER_NIPPLE);
    color(GREY)
        translate(position)
            cylinder(
                h = BORDER_NIPPLE,
                d = diameter,
                $fn = FINE);
}
module nipple()
{
    top_little();
    shoulder_top_little();
    body_central_little();
    milling_nipple_base();
    base_cylinder();
           
//Nipple base shoulder
color(GREY)
translate([0,0,-HEIGHT_NIPPLE])
    rotate_extrude(convexity = CONVEXITY, $fn = FINE)
    translate([(DIAMETER_BASE_NIPPLE/2)-BORDER_NIPPLE, 0, 0])
        circle(r = BORDER_NIPPLE, $fn = FINE);
 
} 

nipple();

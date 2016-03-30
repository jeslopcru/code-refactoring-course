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
module nipple()
{
    top_little();
    shoulder_top_little();
    
//Main nipple cylinder
color(GREY)
translate([0,0,-(HEIGHT_NIPPLE - BORDER_NIPPLE)])
    cylinder(
        h = (HEIGHT_NIPPLE - (BORDER_NIPPLE + BORDER_NIPPLE)),
        d = DIAMETER_NIPPLE,
        $fn = FINE);

//Main nipple cylinder; base fillet
color(GREY)
difference()
{
    translate([0,0,BORDER_NIPPLE - HEIGHT_NIPPLE])
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
        translate([(DIAMETER_NIPPLE/2), 0, 0])
            square((BORDER_NIPPLE),(BORDER_NIPPLE));

    translate([0,0,(2 * BORDER_NIPPLE) - HEIGHT_NIPPLE])
        rotate_extrude(convexity = CONVEXITY, $fn = FINE)
        translate([(DIAMETER_NIPPLE/2)+ BORDER_NIPPLE, 0, 0])
            circle(r = BORDER_NIPPLE, $fn = FINE);
}
        
//Nipple shoulder cylinder
color(GREY)
translate([0,0,-HEIGHT_NIPPLE])
    cylinder(
        h = BORDER_NIPPLE,
        d = DIAMETER_BASE_NIPPLE - (2 * BORDER_NIPPLE),
        $fn = FINE);
        
//Nipple base shoulder
color(GREY)
translate([0,0,-HEIGHT_NIPPLE])
    rotate_extrude(convexity = CONVEXITY, $fn = FINE)
    translate([(DIAMETER_BASE_NIPPLE/2)-BORDER_NIPPLE, 0, 0])
        circle(r = BORDER_NIPPLE, $fn = FINE);
 
} 

nipple();

HEIGHT_NIPPLE = 0.8;
DIAMETER_NIPPLE = 3;
BORDER_NIPPLE = 0.2;
DIAMETER_BASE_NIPPLE = 6;

GREY = "LightGrey";

module nipple()
{
    color(GREY)
        translate([0,0,-BORDER_NIPPLE])
            cylinder(
                h = BORDER_NIPPLE, 
                d = (DIAMETER_NIPPLE - (2 * BORDER_NIPPLE)),
                $fn = 100);
    
    //First shoulder
color(GREY)
translate([0,0,-BORDER_NIPPLE])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_NIPPLE/2)-BORDER_NIPPLE, 0, 0])
        circle(r = BORDER_NIPPLE, $fn = 100);

//Main nipple cylinder
color(GREY)
translate([0,0,-(HEIGHT_NIPPLE - BORDER_NIPPLE)])
    cylinder(
        h = (HEIGHT_NIPPLE - (BORDER_NIPPLE + BORDER_NIPPLE)),
        d = DIAMETER_NIPPLE,
        $fn = 100);

//Main nipple cylinder; base fillet
color(GREY)
difference()
{
    translate([0,0,BORDER_NIPPLE - HEIGHT_NIPPLE])
        rotate_extrude(convexity = 10, $fn = 100)
        translate([(DIAMETER_NIPPLE/2), 0, 0])
            square((BORDER_NIPPLE),(BORDER_NIPPLE));

    translate([0,0,(2 * BORDER_NIPPLE) - HEIGHT_NIPPLE])
        rotate_extrude(convexity = 10, $fn = 100)
        translate([(DIAMETER_NIPPLE/2)+ BORDER_NIPPLE, 0, 0])
            circle(r = BORDER_NIPPLE, $fn = 100);
}
        
//Nipple shoulder cylinder
color(GREY)
translate([0,0,-HEIGHT_NIPPLE])
    cylinder(
        h = BORDER_NIPPLE,
        d = DIAMETER_BASE_NIPPLE - (2 * BORDER_NIPPLE),
        $fn = 100);
        
//Nipple base shoulder
color(GREY)
translate([0,0,-HEIGHT_NIPPLE])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BASE_NIPPLE/2)-BORDER_NIPPLE, 0, 0])
        circle(r = BORDER_NIPPLE, $fn = 100);
 
} 

nipple();

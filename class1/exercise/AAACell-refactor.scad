HEIGHT = 44.5;
HEIGHT_BODY = 44.5;
DIAMETER_BODY = 10.4;
BORDER_RADIUS_BODY = 0.2;

DIAMETER_BASE = 6;
BORDER_RADIUS_BASE = 0.3;


module RenderCell()
{

nippleHeight = 0.8; //Height from spec (Min: 0.8)
nippleDia = 3; //Diameter from spec (Max: 3.8)
nippleFilletRad = 0.2;
nippleShoulderDia = 6;

labelThickness = 0.005; //Thickness of plastic

//Top face of nipple
color("LightGrey")
translate([0,0,-nippleFilletRad])
    cylinder(
        h = nippleFilletRad, 
        d = (nippleDia - (2 * nippleFilletRad)),
        $fn = 100);
        
//First shoulder
color("LightGrey")
translate([0,0,-nippleFilletRad])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(nippleDia/2)-nippleFilletRad, 0, 0])
        circle(r = nippleFilletRad, $fn = 100);

//Main nipple cylinder
color("LightGrey")
translate([0,0,-(nippleHeight - nippleFilletRad)])
    cylinder(
        h = (nippleHeight - (nippleFilletRad + nippleFilletRad)),
        d = nippleDia,
        $fn = 100);

//Main nipple cylinder; base fillet
color("LightGrey")
difference()
{
    translate([0,0,nippleFilletRad - nippleHeight])
        rotate_extrude(convexity = 10, $fn = 100)
        translate([(nippleDia/2), 0, 0])
            square((nippleFilletRad),(nippleFilletRad));

    translate([0,0,(2 * nippleFilletRad) - nippleHeight])
        rotate_extrude(convexity = 10, $fn = 100)
        translate([(nippleDia/2)+ nippleFilletRad, 0, 0])
            circle(r = nippleFilletRad, $fn = 100);
}
        
//Nipple shoulder cylinder
color("LightGrey")
translate([0,0,-nippleHeight])
    cylinder(
        h = nippleFilletRad,
        d = nippleShoulderDia - (2 * nippleFilletRad),
        $fn = 100);
        
//Nipple base shoulder
color("LightGrey")
translate([0,0,-nippleHeight])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(nippleShoulderDia/2)-nippleFilletRad, 0, 0])
        circle(r = nippleFilletRad, $fn = 100);

//Top face of main body
translate([0,0,-(nippleHeight + BORDER_RADIUS_BODY)])
    cylinder(
        h = BORDER_RADIUS_BODY, 
        d = (DIAMETER_BODY - (2 * BORDER_RADIUS_BODY)),
        $fn = 100);
        
//Body top shoulder
translate([0,0,-(nippleHeight + BORDER_RADIUS_BODY)])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BODY/2)-BORDER_RADIUS_BODY, 0, 0])
        circle(r = BORDER_RADIUS_BODY, $fn = 100);

//Main body cylinder
translate([0,0,-(HEIGHT_BODY - BORDER_RADIUS_BODY)])
    cylinder(
        h = (HEIGHT_BODY - (nippleHeight + (2* BORDER_RADIUS_BODY))),
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

//Base cylinder
color("LightGrey")
translate([0,0,-(HEIGHT_BODY + BORDER_RADIUS_BASE)])
    cylinder(
        h = BORDER_RADIUS_BASE, 
        d = (DIAMETER_BASE - (2 * BORDER_RADIUS_BASE)),
        $fn = 100);

//Base shoulder
color("LightGrey")
translate([0,0,-(HEIGHT_BODY)])
    rotate_extrude(convexity = 10, $fn = 100)
    translate([(DIAMETER_BASE/2)-BORDER_RADIUS_BASE, 0, 0])
        circle(r = BORDER_RADIUS_BASE, $fn = 100);
}
RenderCell();
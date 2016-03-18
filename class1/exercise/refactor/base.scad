include <constants.scad>;
DIAMETER_BASE = 6;
DIAMETER_OUTER_RING = 0.6;
THICKNESS = 0.3; 
CONVEXITY = 10;

module base()
{
    surface();
    border();
}

module surface()
{
    offset_z = - HEIGHT_BODY - THICKNESS;
    offset = [0, 0, offset_z];
    
    diameter_total = DIAMETER_BASE - DIAMETER_OUTER_RING;
    
    color(GREY)
        translate(offset)
            cylinder(h = THICKNESS, d = diameter_total, $fn = FINE);
}

module border()
{
    offset_z = -HEIGHT_BODY;
    offset_base = [0, 0, offset_z];
    
    offset_x = radius(DIAMETER_BASE) - radius(DIAMETER_OUTER_RING);
    offset_border = [offset_x, 0, 0];
    
    color(GREY)
        translate(offset_base)
            rotate_extrude(convexity = CONVEXITY, $fn = FINE)
                translate(offset_border)
                    circle(r = THICKNESS, $fn = FINE);
}

base();

function radius(diameter) = diameter / 2;

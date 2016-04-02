include <constants.scad>;

DIAMETER_BASE = 6;
DIAMETER_OUTER_RING = 0.6;
THICKNESS = 0.3; 

module base()
{
    surface();
    border(-HEIGHT_BODY);
}

module surface()
{
    position_z = - HEIGHT_BODY - THICKNESS;
    position = [0, 0, position_z];
    
    diameter_total = DIAMETER_BASE - DIAMETER_OUTER_RING;
    
    color(GREY)
        translate(position)
            cylinder(h = THICKNESS, d = diameter_total, $fn = FINE);
}

module border(position_base_z)
{
    position_base = [0, 0, position_base_z];
    
    position_border_x = radius(DIAMETER_BASE) - radius(DIAMETER_OUTER_RING);

    position_border = [position_border_x, 0, 0];
    
    color(GREY)
        translate(position_base)
            rotate_extrude(convexity = CONVEXITY, $fn = FINE)
                translate(position_border)
                    circle(r = THICKNESS, $fn = FINE);
}

base();
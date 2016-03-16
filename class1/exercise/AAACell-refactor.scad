use <nipple.scad>;
use <body.scad>;
use <base.scad>;

module render_cell()
{
    nipple();
    body();
    base();
}

render_cell();
let canvas;
let width;
let height;

let jump = 0;

let car_jump = 0;

let car;
let car_position;
let car_width;
let car_height;
let car_position_y;
let car_position_x;

let radius;
let radius_tires;
let degrees = 0;

let rotationDegrees = 0;
let shift_x = 0;
let shift_y = 0;

let wheel_jump = 0;

let wheel_1_center_x;
let wheel_1_center_y;

let wheel_jump_2 = 0;

let wheel_2_center_x;
let wheel_2_center_y;

let gap;

let x1_stop;
let x2_stop;
let y1_line;
let y2_line;

let ok = false;
let tmp = 0;

let y_const = 0;

window.addEventListener('resize', resizeAll, false);

function initt(){
    width = $("#casForm").width();
    height = $("#casForm").height()*2;

    car_width = width/2;
    car_height = height/2.5;

    car_position = $("#casForm").height();
    car_position_y = car_position + car_jump;
    car_position_x = 100;

    radius = car_width/13;
    radius_tires = radius+car_width/80;

    wheel_1_center_x = car_position_x + car_width/1.275;
    wheel_1_center_y = car_position_y + car_height - (radius/3) - wheel_jump;

    wheel_2_center_x = car_position_x + car_width/5.3;
    wheel_2_center_y = car_position_y + car_height - (radius/3) - wheel_jump_2;

    y1_line = car_position_y + car_height - (radius/3);
    y2_line = car_position_y + car_height - (radius/3) + jump;

    // y_const =
}

function preload() {
    car = loadImage('/img/car.png');
}

function resizeAll(){
    initt();
    resizeCanvas(width, height);
}

function windowResized() {
    resizeAll();
}

function setup() {
    initt();
    x1_stop = wheel_1_center_x+(radius/2);
    x2_stop = width;
    gap = wheel_1_center_y - car_position_y - ((radius_tires));
    angleMode(DEGREES);
    canvas = createCanvas(width, height);
    canvas.parent("animationDiv");
    noLoop();
}

function draw() {

    initt();
    clear();

    /* Krivka - cesta */
    line(0, y1_line+((radius+radius_tires)/2), x1_stop, y1_line+((radius+radius_tires)/2));
    /* Koniec krivky */

    /* Skok */
    line(x1_stop, y1_line+((radius+radius_tires)/2), x1_stop, y2_line+((radius+radius_tires)/2));
    /* Koniec skoku */

    /* Krivka - cesta */
    line(x1_stop, y2_line+((radius+radius_tires)/2), x2_stop, y2_line+((radius+radius_tires)/2));
    /* Koniec krivky */

    /* Predne koleso */
    ellipseMode(CENTER);
    fill(10);
    ellipse(wheel_1_center_x, wheel_1_center_y, radius*2, radius*2);

    ellipseMode(CENTER);
    fill(230);
    ellipse(wheel_1_center_x, wheel_1_center_y, radius_tires, radius_tires);

    stroke(0, 0, 0);
    line(wheel_1_center_x, wheel_1_center_y, radius * cos(degrees) + wheel_1_center_x,
        radius * sin(degrees) + wheel_1_center_y);
    /* Predne koleso koniec */


    /* Zadne koleso */
    ellipseMode(CENTER);
    fill(10);
    ellipse(wheel_2_center_x, wheel_2_center_y, radius*2, radius*2);

    ellipseMode(CENTER);
    fill(230);
    ellipse(wheel_2_center_x, wheel_2_center_y, radius_tires, radius_tires);

    stroke(0, 0, 0);
    line(wheel_2_center_x, wheel_2_center_y, radius * cos(degrees) + wheel_2_center_x,
        radius * sin(degrees) + wheel_2_center_y);
    /* Zadne koleso koniec */


    /* Konštrukcia auta */
    translate(shift_x, shift_y);
    rotate(rotationDegrees);
    image(car, car_position_x, car_position_y, car_width, car_height);
    /* Konštrukcia auta koniec */

}

function roundToOne(num) {
    return +(Math.round(num + "e+1")  + "e-1");
}

function test (obstacleHeight, time, y_wheel, y_car, y_wheel_prev, y_car_prev){
    //clear();
    if(y_wheel !== undefined){

        if(x1_stop - 1 < 0)
            x1_stop = 0;
        else
            x1_stop = x1_stop - 1;

        jump = -parseFloat(obstacleHeight)*(radius_tires);

        wheel_jump = parseFloat(y_wheel)*(radius_tires);
        wheel_jump_2 = parseFloat(y_wheel_prev)*(radius_tires);

        car_jump = parseFloat(y_car)*(radius_tires);

        // shift_y =  - Math.abs(car_jump -wheel_jump);

        //car_jump = (parseFloat(y_car) + parseFloat(y_wheel)) * (radius_tires);

        rotationDegrees = Math.atan2(Math.abs(wheel_2_center_y-wheel_1_center_y),
            Math.abs(wheel_2_center_x-wheel_1_center_x)) * ( 180 / Math.PI );

        if(wheel_2_center_y-wheel_1_center_y > 0)
            rotationDegrees = -rotationDegrees;

        if(roundToOne(Math.abs(Math.abs(x1_stop-wheel_2_center_x)-(radius_tires/2))) < 1){
            ok = true;
        }
        // if(Math.abs(roundToOne(rotationDegrees)) === 0){
        //     shift_x = 0;
        // } else {
        //     shift_x = -car_jump -wheel_jump;
        // }
        if(Math.abs(roundToOne(rotationDegrees)) === 0 || ok === true){
            shift_x = 0;
            shift_y = -car_jump -wheel_jump;
        }
        else {
            // shift_x = - wheel_jump - wheel_jump_2;
            shift_x = -car_jump -wheel_jump;
            shift_y =  -car_jump +wheel_jump;
        }

        //clear();
        degrees = degrees + 5;
        redraw();
    } else {
        degrees = 0;
        rotationDegrees = 0;
        shift_x = shift_x/100;
        shift_y = -car_jump -wheel_jump;
        redraw();
    }
}

function clearCanvas(){
    clear();
    ok = false;
    jump = 0;
    car_jump = 0;
    rotationDegrees = 0;
    degrees = 0;
    shift_x = 0;
    shift_y = 0;
    wheel_jump = 0;
    wheel_jump_2 = 0;
    setup();

    background(255);
}

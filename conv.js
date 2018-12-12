window.onload = init();

function init() {
  document.getElementById("results").setAttribute("style", "display:none");
  document.getElementById("submitButton").addEventListener("click", calcul);
}

function calcul(latIn, longIn) {
  console.log("calcul..");
  let latitudeIn = latIn;
  let longitudeIn = longIn;

  //Constantes
  let n = 0.7289686274;
  let C = 11745793.39;
  let e = 0.08248325676;
  let Xs = 600000;
  let Ys = 8199695.768;

  latitudeIn = (latitudeIn / (180 * 3600)) * Math.PI;
  longitudeIn = (longitudeIn / (180 * 3600)) * Math.PI;

  console.log("Lat", latitudeIn);
  console.log("Lon", longitudeIn);

  //Calcul de GAMMA
  let gamma0 = 3600 * 2 + 60 * 20 + 14.025;
  gamma0 = (gamma0 / (180 * 3600)) * Math.PI;

  console.log("Gamma0", gamma0);

  //Calcul de L
  let L =
    0.5 * Math.log((1 + Math.sin(latitudeIn)) / (1 - Math.sin(latitudeIn))) -
    (e / 2) *
      Math.log((1 + e * Math.sin(latitudeIn)) / (1 - e * Math.sin(latitudeIn)));
  let R = C * Math.exp(-n * L);

  let gamma = n * (longitudeIn - gamma0);

  console.log("L", L);
  console.log("R", R);

  //Result
  let Lx = Xs + R * Math.sin(gamma);
  let Ly = Ys - R * Math.cos(gamma);

  console.log(Lx);

  document.getElementById("results").setAttribute("style", "display:block");
  document.getElementById("resX").innerHTML = Lx;
  document.getElementById("resY").innerHTML = Ly;
}

/*

calcul..
Lat 0.852682525924007
Lon 0.040968319093063685
Gamma0 0.040792344331976635
L 0.9748289638799995
R 5771173.476845259
Ly 600740.3265935425

*/

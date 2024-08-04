function mode() {
  document.getElementById("hentai").classList.toggle("w");
  this.classList.toggle("on");
}
document.querySelector(".btn-mode").addEventListener("click", mode);
function menu() {
  document.getElementById("hd").classList.toggle("on");
  this.classList.toggle("on");
}
document.querySelector(".menu-btn").addEventListener("click", menu);

let namePage = [
  "java",
  "webDevelopment",
  "dataScience",
  "c++",
  "python",
  "graphicDesign",
  "dataBases",
  "softwareEngineer",
  "cyberSecurity",
];
let visit = document.querySelectorAll(".visit");
for (let i = 0; i < visit.length; i++) {
  visit[i].addEventListener("click", function () {
    window.location.href = `./${namePage[i]}.html`;
  });
}
let span = document.querySelector(".up");
window.onscroll = function () {
  this.scrollY >= 600
    ? span.classList.add("show-up")
    : span.classList.remove("show-up");
};
span.onclick = function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};

let nums = document.querySelectorAll(".nums .num");
let section = document.querySelector(".thr");
let started = false;
let section2 = document.querySelector(".three");
let spans = document.querySelectorAll(".progress span");
let started2 = false;

window.addEventListener("scroll", function () {
  if (window.scrollY >= section.offsetTop && !started) {
    nums.forEach((num) => startCount(num));
    started = true;
  }
  if (window.scrollY >= section2.offsetTop && !started2) {
    spans.forEach((span) => {
      span.style.width = span.dataset.width;
    });
    started2 = true;
  }
});
function startCount(el) {
  let goal = el.dataset.goal;
  let count = 0;
  let increment = Math.ceil(goal / 200);

  let interval = setInterval(() => {
    count += increment;
    if (count >= goal) {
      count = goal;
      clearInterval(interval);
    }
    el.textContent = count;
  }, 2000 / goal);
}
$(".collapse")
  .on("show.bs.collapse", function () {
    $(this).parent().find(".card-header").addClass("active");
  })
  .on("hide.bs.collapse", function () {
    $(this).parent().find(".card-header").removeClass("active");
  });
document.querySelector("form").addEventListener("submit", function (e) {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  if (!name || !email) {
    e.preventDefault();
    alert("يرجى ملء جميع الحقول المطلوبة.");
  }
});
AOS.init();
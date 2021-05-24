import { Element } from "./modules/Element.js";
import { Section } from "./modules/SectionElement.js";
import { Title } from "./modules/TitleElement.js";

const contentEditables = [];

document.addEventListener("DOMContentLoaded", function () {
  document.execCommand("defaultParagraphSeparator", false, "div");

  document.getElementById("AddSection").addEventListener("click", AddSection);
  document.getElementById("AddTitle").addEventListener("click", AddTitle);
  document.getElementById("ToJson").addEventListener("click", ToJson);
  document.getElementById("ToHtml").addEventListener("click", ShowInHtml);
});

function AddSection() {
  contentEditables.push(new Section("edit"));
}

function AddTitle() {
  contentEditables.push(new Title("edit"));
}

function ToJson() {
  var json = { pageContent: [] };
  contentEditables.forEach((element) => {
    json.pageContent.push(element.ToJson());
  });
  alert(JSON.stringify(json));
}

function ShowInHtml() {
  var addPos = document.getElementById("result");
  addPos.innerHTML = "";
  contentEditables.forEach((element) => {
    addPos.appendChild(element.ToHtml());
  });
}

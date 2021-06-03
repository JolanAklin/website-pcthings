import { Element } from "./modules/Element.js";
import { Paragraph } from "./modules/ParagraphElement.js";
import { Title } from "./modules/TitleElement.js";
import { Title2 } from "./modules/Title2Element.js";
import { Quote } from "./modules/QuoteElement.js";
import { Code } from "./modules/CodeElement.js";

const contentEditables = [];

document.addEventListener("DOMContentLoaded", function () {
  document.execCommand("defaultParagraphSeparator", false, "div");

  document.getElementById("AddParagraph").addEventListener("click", AddParagraph);
  document.getElementById("AddTitle").addEventListener("click", AddTitle);
  document.getElementById("AddTitle2").addEventListener("click", AddTitle2);
  document.getElementById("AddQuote").addEventListener("click", AddQuote);
  document.getElementById("AddCode").addEventListener("click", AddCode);

  document.getElementById("ToJson").addEventListener("click", ToJson);
  document.getElementById("ToHtml").addEventListener("click", ShowInHtml);
});

function AddParagraph() {
  contentEditables.push(new Paragraph("edit"));
}

function AddTitle() {
  contentEditables.push(new Title("edit"));
}

function AddTitle2() {
  contentEditables.push(new Title2("edit"));
}

function AddQuote() {
  contentEditables.push(new Quote("edit"));
}

function AddCode() {
  contentEditables.push(new Code("edit"));
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

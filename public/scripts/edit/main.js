import { Element } from "./modules/Element.js";
import { Paragraph } from "./modules/ParagraphElement.js";
import { Title } from "./modules/TitleElement.js";
import { Title2 } from "./modules/Title2Element.js";
import { Quote } from "./modules/QuoteElement.js";
import { Code } from "./modules/CodeElement.js";

var id = 0;
var contentEditables = [];

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
  contentEditables.push(new Paragraph("edit", id, Remove, MoveElement));
  id = id + 1;
}

function AddTitle() {
  contentEditables.push(new Title("edit", id, Remove, MoveElement));
  id = id + 1;
}

function AddTitle2() {
  contentEditables.push(new Title2("edit", id, Remove, MoveElement));
  id = id + 1;
}

function AddQuote() {
  contentEditables.push(new Quote("edit", id, Remove, MoveElement));
  id = id + 1;
}

function AddCode() {
  contentEditables.push(new Code("edit", id, Remove, MoveElement));
  id = id + 1;
}

function Remove(objectId) {
  contentEditables = contentEditables.filter(x => x.id != objectId);
}

// from https://www.geeksforgeeks.org/how-to-move-an-array-element-from-one-array-position-to-another-in-javascript/ modified
function MoveElement(objectId, dir) {
  var toMove = contentEditables.find(obj => obj.id == objectId);
  var x = contentEditables.indexOf(toMove);
    
  if(dir > 1)
  {
    dir = 1;
  }
  if(dir < -1)
  {
    dir = -1;
  }
  var pos = x - dir;
  if(pos < 0 || pos > contentEditables.length-1)
  {
    return;
  }

  if(dir == -1)
    toMove.mainDiv.parentNode.insertBefore(contentEditables[pos].mainDiv, toMove.mainDiv);
  if(dir == 1)
    toMove.mainDiv.parentNode.insertBefore(toMove.mainDiv, contentEditables[pos].mainDiv);

  var temp = contentEditables[x]; 
  contentEditables[x] = contentEditables[pos];
  contentEditables[pos] = temp;
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

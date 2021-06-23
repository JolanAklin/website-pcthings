import { Element } from "./modules/Element.js";
import { Paragraph } from "./modules/ParagraphElement.js";
import { Title } from "./modules/TitleElement.js";
import { Title2 } from "./modules/Title2Element.js";
import { Quote } from "./modules/QuoteElement.js";
import { Code } from "./modules/CodeElement.js";
import { Table } from "./modules/TableElement.js";

var id = 0;
var contentEditables = [];

document.addEventListener("DOMContentLoaded", function () {
  document.execCommand("defaultParagraphSeparator", false, "div");

  document
    .getElementById("AddParagraph")
    .addEventListener("click", AddParagraph);
  document.getElementById("AddTitle").addEventListener("click", AddTitle);
  document.getElementById("AddTitle2").addEventListener("click", AddTitle2);
  document.getElementById("AddQuote").addEventListener("click", AddQuote);
  document.getElementById("AddCode").addEventListener("click", AddCode);
  document.getElementById("AddTable").addEventListener("click", AddTable);
  document
    .getElementById("ValidateForm")
    .addEventListener("click", ValidateForm);

  // check if there is some data to read and create the corresponding elements
  var fillsWithJSON = document.getElementsByClassName("fillWithJSON");
  var readJsonFrom = fillsWithJSON[0];
  if (readJsonFrom.value != "") {
    var parsedJson = JSON.parse(readJsonFrom.value);
    parsedJson.pageContent.forEach((element) => {
      switch (element.Type) {
        case "p":
          AddParagraph().FromJson(element);
          break;
        case "h":
          AddTitle().FromJson(element);
          break;
        case "h2":
          AddTitle2().FromJson(element);
          break;
        case "quote":
          AddQuote().FromJson(element);
          break;
        case "code":
          AddCode().FromJson(element);
          break;

        default:
          break;
      }
    });
  }
});

function AddParagraph() {
  var p = new Paragraph("edit", id, Remove, MoveElement);
  contentEditables.push(p);
  id = id + 1;
  return p;
}

function AddTitle() {
  var h = new Title("edit", id, Remove, MoveElement);
  contentEditables.push(h);
  id = id + 1;
  return h;
}

function AddTitle2() {
  var h2 = new Title2("edit", id, Remove, MoveElement);
  contentEditables.push(h2);
  id = id + 1;
  return h2;
}

function AddQuote() {
  var quote = new Quote("edit", id, Remove, MoveElement);
  contentEditables.push(quote);
  id = id + 1;
  return quote;
}

function AddCode() {
  var code = new Code("edit", id, Remove, MoveElement);
  contentEditables.push(code);
  id = id + 1;
  return code;
}
function AddTable() {
  var table = new Table("edit", id, Remove, MoveElement);
  contentEditables.push(table);
  id = id + 1;
  return table;
}

function Remove(objectId) {
  contentEditables = contentEditables.filter((x) => x.id != objectId);
}

// from https://www.geeksforgeeks.org/how-to-move-an-array-element-from-one-array-position-to-another-in-javascript/ modified
function MoveElement(objectId, dir) {
  var toMove = contentEditables.find((obj) => obj.id == objectId);
  var x = contentEditables.indexOf(toMove);

  if (dir > 1) {
    dir = 1;
  }
  if (dir < -1) {
    dir = -1;
  }
  var pos = x - dir;
  if (pos < 0 || pos > contentEditables.length - 1) {
    return;
  }

  if (dir == -1)
    toMove.mainDiv.parentNode.insertBefore(
      contentEditables[pos].mainDiv,
      toMove.mainDiv
    );
  if (dir == 1)
    toMove.mainDiv.parentNode.insertBefore(
      toMove.mainDiv,
      contentEditables[pos].mainDiv
    );

  var temp = contentEditables[x];
  contentEditables[x] = contentEditables[pos];
  contentEditables[pos] = temp;
}

function ShowInHtml() {
  var addPos = document.getElementById("result");
  addPos.innerHTML = "";
  contentEditables.forEach((element) => {
    addPos.appendChild(element.ToHtml());
  });
}

function ConvertToJSON() {
  var json = { pageContent: [] };
  contentEditables.forEach((element) => {
    json.pageContent.push(element.ToJson());
  });
  return JSON.stringify(json);
}

function ValidateForm() {
  var editForms = document.getElementsByClassName("editForm");
  var fillsWithJSON = document.getElementsByClassName("fillWithJSON");
  fillsWithJSON[0].value = ConvertToJSON();
  editForms[0].submit();
}

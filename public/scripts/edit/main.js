//MIT License

//Copyright (c) 2021 Jolan Aklin and Yohan Zbinden

//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "text editor"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:

//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.

//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.

import { Element } from "./modules/Element.js";
import { Paragraph } from "./modules/ParagraphElement.js";
import { Title } from "./modules/TitleElement.js";
import { Title2 } from "./modules/Title2Element.js";
import { Quote } from "./modules/QuoteElement.js";
import { Code } from "./modules/CodeElement.js";
import { Image } from "./modules/ImageElement.js";

var id = 0;
var contentEditables = [];

document.addEventListener("DOMContentLoaded", function () {
  document.execCommand("defaultParagraphSeparator", false, "div");

  document.getElementById("AddParagraph").addEventListener("click", AddParagraph);
  document.getElementById("AddTitle").addEventListener("click", AddTitle);
  document.getElementById("AddTitle2").addEventListener("click", AddTitle2);
  document.getElementById("AddQuote").addEventListener("click", AddQuote);
  document.getElementById("AddImage").addEventListener("click", AddImage);
  document.getElementById("AddCode").addEventListener("click", AddCode);

  document.getElementById("ValidateForm").addEventListener("click", ValidateForm);

  // check if there is some data to read and create the corresponding elements
  var fillsWithJSON = document.getElementsByClassName("fillWithJSON");
  var readJsonFrom = fillsWithJSON[0];
  if(readJsonFrom.value != "") {
    var parsedJson = JSON.parse(readJsonFrom.value);
    parsedJson.pageContent.forEach(element => {
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
        case "img":
          AddImage().FromJson(element);
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
  var h = new Title("edit", id, Remove, MoveElement)
  contentEditables.push(h);
  id = id + 1;
  return h;
}

function AddTitle2() {
  var h2 = new Title2("edit", id, Remove, MoveElement)
  contentEditables.push(h2);
  id = id + 1;
  return h2;
}

function AddImage() {
  var image = new Image("edit", id, Remove, MoveElement);
  contentEditables.push(image);
  id = id + 1;
  return image;
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

window.ImageCallback = function (imageId, elementId) {
  axios.post('/images/get/'+imageId).then(function(response) {
    const jsonImage = JSON.parse(response.data.image);
    const imageElement = contentEditables.find(obj => obj.id == elementId);
    imageElement.image.src = jsonImage.path;
    imageElement.image.alt = jsonImage.alt;
    imageElement.imageId = imageId;
    imageElement.imageTitle.innerHTML = jsonImage.title;
  });
}

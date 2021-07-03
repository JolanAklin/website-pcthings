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

import { Element } from "./Element.js";

export function Paragraph(idPosition, id, destroyFunction, moveElement) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Paragraph", this.id, this.destroyFunction, this.mainDiv, moveElement));

    this.mainDiv.className = "page-element input-paragraph";
    this.mainTextDiv.className = "page-element-input input-paragraph";
    this.mainTextDiv.contentEditable = true;
    this.mainDiv.appendChild(this.mainTextDiv);

    this.addPositionNode.appendChild(this.mainDiv);
  };

  Paragraph.prototype.ToJson = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content = "";
    // loop throught all the divs inside the text div to put the text in the right format
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    }else {
      var i = 0;
      contentDivs.forEach((element) => {
        console.log(element.textContent);
        if(i == contentDivs.length - 1)
          content += encodeURIComponent(element.textContent);
        else
          content += encodeURIComponent(element.textContent + "\n");
        i += 1;
      });
    }
    return { Type:"p", Content: content };
  };

  Paragraph.prototype.FromJson = function (json) {
    var contentString = decodeURIComponent(json.Content);
    var contentStringSplit = contentString.split("\n");
    contentStringSplit.forEach(element => {
      var div = document.createElement("DIV");
      div.textContent = element;
      this.mainTextDiv.appendChild(div);
    });
  };

  CreateElement();
}

Paragraph.prototype = new Element();

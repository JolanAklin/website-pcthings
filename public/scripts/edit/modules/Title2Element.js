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

export function Title2(idPosition, id, destroyFunction, moveElement) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.title = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Title 2", this.id, this.destroyFunction, this.mainDiv, moveElement));

    this.mainDiv.className = "page-element input-title2";
    this.title.contentEditable = true;
    this.title.className = "page-element-input input-title2";
    this.mainDiv.appendChild(this.title);
    this.addPositionNode.appendChild(this.mainDiv);
  };

  Title2.prototype.ToJson = function () {
    var content = this.title.textContent;
    return { Type:"h2", Content: content };
  };

  Title2.prototype.FromJson = function (json) {
    this.title.textContent = json.Content;
  };

  CreateElement();
}

Title2.prototype = new Element();

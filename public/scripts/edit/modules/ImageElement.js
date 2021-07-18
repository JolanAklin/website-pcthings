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

export function Image(idPosition, id, destroyFunction, moveElement) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.chooseImage = document.createElement("A");

  this.image = document.createElement("IMG");

  this.imageTitle = document.createElement("P");

  this.imageId = -1;

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Image", this.id, this.destroyFunction, this.mainDiv, moveElement));
    this.chooseImage.innerHTML = "Choose an image";
    this.chooseImage.className = "button-slicker inverted";
    this.imageTitle.className = "image-title";
    this.mainDiv.className = "page-element image-element";
    this.chooseImage.addEventListener("click", function(params) {
      var popup = window.open("/choose-picture/", "test", "resizable,scrollbars,width=800,height=600,toolbar=no,menubar=no");
      popup.onload = function () {
        popup.SetElementId(id);
      }
    })
    this.mainDiv.appendChild(this.chooseImage);
    this.mainDiv.appendChild(this.image);
    this.mainDiv.appendChild(this.imageTitle);
    this.addPositionNode.appendChild(this.mainDiv);
  };

  Image.prototype.ToJson = function () {
    return { Type:"img", Content: { imageId: this.imageId, src: this.image.src, alt: this.image.alt, imageTitle: this.imageTitle.innerText } };
  };

  Image.prototype.FromJson = function (json) {
    var imageId = json.Content.imageId;
    var imgObject = this;
    axios.post('/images/get/'+imageId).then(function(response) {
      const jsonImage = JSON.parse(response.data.image);
      imgObject.image.src = jsonImage.path;
      imgObject.image.alt = jsonImage.alt;
      imgObject.imageId = imageId;
      imgObject.imageTitle.innerText = jsonImage.title;
    });
  };

  CreateElement();
}

Image.prototype = new Element();

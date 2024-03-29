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

export function Element() {
  Element.prototype.ToJson = function () {
    return {};
  };

  Element.prototype.FromJson = function (json) {
    return "";
  }

  Element.prototype.CreateHeader = function(name, id, destroyFunction, mainDiv, moveElement) {

    var removeButton = document.createElement("BUTTON");
    var upButton = document.createElement("BUTTON");
    var downButton = document.createElement("BUTTON");

    var elementHeader = document.createElement("DIV");
    elementHeader.className = "element-header";

    // create a text element to display the element name
    var infoText = document.createElement("P");
    infoText.className = "page-element-info-text";
    infoText.innerHTML = name;
    elementHeader.appendChild(infoText);

    // create the up button
    var removeButtonImg = document.createElement("IMG");
    removeButtonImg.src = "/images/icons/small_arrow.png";
    upButton.appendChild(removeButtonImg);
    upButton.className = "control-button page-element-up-button";
    elementHeader.appendChild(upButton);
    upButton.addEventListener("click", function() { moveElement(id, 1); });

    
    // create the down button
    var removeButtonImg = document.createElement("IMG");
    removeButtonImg.src = "/images/icons/small_arrow.png";
    downButton.appendChild(removeButtonImg);
    downButton.className = "control-button page-element-down-button";
    elementHeader.appendChild(downButton);
    downButton.addEventListener("click", function() { moveElement(id, -1); });
    
    // create the remove button
    var removeButtonImg = document.createElement("IMG");
    removeButtonImg.src = "/images/icons/close.png";
    removeButton.appendChild(removeButtonImg);
    removeButton.className = "control-button page-element-remove-button";
    elementHeader.appendChild(removeButton);
    removeButton.addEventListener("click", function() { Delete(id, destroyFunction, mainDiv); });

    return elementHeader;
  }

  function Delete(id, destroyFunction, mainDiv) {
    destroyFunction(id);
    mainDiv.parentNode.removeChild(mainDiv);
  }
}

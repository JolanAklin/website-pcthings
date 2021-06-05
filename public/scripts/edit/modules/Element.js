export function Element() {
  Element.prototype.ToJson = function () {
    return {};
  };

  Element.prototype.ToHtml = function () {
    return "";
  };

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

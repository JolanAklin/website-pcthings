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

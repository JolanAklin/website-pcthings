import { Element } from "./Element.js";

export function Quote(idPosition, id, destroyFunction) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Quote", this.id, this.destroyFunction, this.mainDiv));

    this.mainDiv.className = "page-element input-quote";
    this.mainTextDiv.className = "page-element-input input-quote";
    this.mainTextDiv.contentEditable = true;
    this.mainDiv.appendChild(this.mainTextDiv);

    this.addPositionNode.appendChild(this.mainDiv);
  };

  Quote.prototype.ToJson = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content = "";
    // loop throught all the divs inside the text div to put the text in the right format
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    }else {
      contentDivs.forEach((element) => {
        console.log(element.textContent);
        content += encodeURIComponent(element.textContent + "\n");
      });
    }
    return { Type:"quote", Content: content };
  };

  /*
  Quote.prototype.ToHtml = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content;
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    } else {
      contentDivs.forEach((element) => {
        content += element.textContent + "</br>";
      });
    }

    var div = document.createElement("DIV");
    var titleforhtml = document.createElement("H2");
    titleforhtml.innerHTML = this.titleDiv.textContent;
    div.appendChild(titleforhtml);
    var p = document.createElement("P");
    p.innerHTML = content;
    div.appendChild(p);
    return div;
  };
  */

  CreateElement();
}

Quote.prototype = new Element();

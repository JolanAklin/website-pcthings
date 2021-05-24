import { Element } from "./Element.js";

export function Section(idPosition) {
  this.addPositionNode = document.getElementById(idPosition);
  this.mainDiv = document.createElement("DIV");
  this.titleDiv = document.createElement("DIV");
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.className = "section";

    this.titleDiv.className = "section-title";
    this.titleDiv.contentEditable = true;
    this.mainDiv.appendChild(this.titleDiv);

    this.mainTextDiv.className = "section-main-text";
    this.mainTextDiv.contentEditable = true;
    this.mainDiv.appendChild(this.mainTextDiv);

    this.addPositionNode.appendChild(this.mainDiv);
  };

  Section.prototype.ToJson = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content = "";
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent + "\n";
    }else {
      contentDivs.forEach((element) => {
        console.log(element.textContent);
        content += encodeURIComponent(element.textContent + "\n");
      });
    }
    return { Section: { Title: this.titleDiv.textContent, Content: content } };
  };

  Section.prototype.ToHtml = function () {
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

  CreateElement();
}

Section.prototype = new Element();

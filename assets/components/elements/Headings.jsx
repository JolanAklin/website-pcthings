import React from "react";
const FirstHeadElement = (props) => (
  <h1 {...props.attributes}>{props.children}</h1>
);
const SecondHeadElement = (props) => (
  <h2 {...props.attributes}>{props.children}</h2>
);
const ThirdHeadElement = (props) => (
  <h3 {...props.attributes}>{props.children}</h3>
);
export { FirstHeadElement, SecondHeadElement, ThirdHeadElement };

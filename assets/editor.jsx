import { Editor, Transforms, Text } from "slate";
const CustomEditor = {
  isHeadingActive(editor, num) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n.type === `h${num}`,
    });
    return !!match;
  },
  toggleHeading(editor, num) {
    const isActive = CustomEditor.isHeadingActive(editor, num);
    Transforms.setNodes(
      editor,
      { type: isActive ? null : `h${num}` },
      { match: (n) => Editor.isBlock(editor, n) }
    );
  },
  toggleDefault(editor) {
    Transforms.setNodes(
      editor,
      { type: null },
      { match: (n) => Editor.isBlock(editor, n) }
    );
  },
  isBoldMarkActive(editor) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n.bold,
      universal: true,
    });

    return !!match;
  },
  toggleBoldMark(editor) {
    const isActive = CustomEditor.isBoldMarkActive(editor);
    Transforms.setNodes(
      editor,
      { bold: isActive ? null : true },
      { match: (n) => Text.isText(n), split: true }
    );
  },
  isItalicMarkActive(editor) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n.italic,
      universal: true,
    });
    return !!match;
  },
  toggleItalicMark(editor) {
    const isActive = CustomEditor.isItalicMarkActive(editor);
    Transforms.setNodes(
      editor,
      { italic: isActive ? null : true },
      { match: (n) => Text.isText(n), split: true }
    );
  },
  isUnderlineMarkActive(editor) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n["underlined"],
      universal: true,
    });
    return !!match;
  },
  toggleUnderlineMark(editor) {
    const isActive = CustomEditor.isUnderlineMarkActive(editor);
    Transforms.setNodes(
      editor,
      { underlined: isActive ? null : true },
      { match: (n) => Text.isText(n), split: true }
    );
  },
};
export default CustomEditor;

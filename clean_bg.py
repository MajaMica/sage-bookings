import os
import re

def clean_bg_classes():
    views_dir = "resources/views"
    bg_classes = ["bg-white", "bg-neutral-50", "bg-stone-50", "bg-gray-50"]
    pattern = re.compile(r'\b(' + '|'.join(bg_classes) + r')\b')

    for root, _, files in os.walk(views_dir):
        for file in files:
            if file.endswith(".blade.php"):
                filepath = os.path.join(root, file)
                with open(filepath, "r", encoding="utf-8") as f:
                    content = f.read()

                lines = content.split('\n')
                modified = False

                for i, line in enumerate(lines):
                    if line.strip().startswith('<section'):
                        new_line = pattern.sub('', line)
                        if new_line != line:
                            new_line = re.sub(r' +', ' ', new_line)
                            lines[i] = new_line
                            modified = True

                if modified:
                    with open(filepath, "w", encoding="utf-8") as f:
                        f.write('\n'.join(lines))
                    print(f"Izmenjeno: {filepath}")

if __name__ == "__main__":
    clean_bg_classes()

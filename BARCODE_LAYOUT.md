# 📐 Barcode Print Layout - Complete Measurements

## Paper Specifications

**Paper Roll Width:** 10.7cm (107mm)  
**Paper Type:** Continuous Thermal Roll  
**Orientation:** Portrait

---

## Complete Layout Structure

```
┌─────────────────────────────────────────────────────────────────┐
│                      PAPER ROLL: 107mm WIDE                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ 2mm │ ┌───────────┐ │ 2mm │ ┌───────────┐ │ 2mm │ ┌───────────┐ │ 2mm │
│     │ │           │ │     │ │           │ │     │ │           │ │     │
│     │ │  LABEL 1  │ │     │ │  LABEL 2  │ │     │ │  LABEL 3  │ │     │
│     │ │  3.3cm    │ │     │ │  3.3cm    │ │     │ │  3.3cm    │ │     │
│     │ │  × 2.1cm  │ │     │ │  × 2.1cm  │ │     │ │  × 2.1cm  │ │     │
│     │ │           │ │     │ │           │ │     │ │           │ │     │
│     │ └───────────┘ │     │ └───────────┘ │     │ └───────────┘ │     │
│     │                                                                 │
│     │                       ↕ 3mm Gap                                 │
│     │                                                                 │
│ 2mm │ ┌───────────┐ │ 2mm │ ┌───────────┐ │ 2mm │ ┌───────────┐ │ 2mm │
│     │ │           │ │     │ │           │ │     │ │           │ │     │
│     │ │  LABEL 4  │ │     │ │  LABEL 5  │ │     │ │  LABEL 6  │ │     │
│     │ │  3.3cm    │ │     │ │  3.3cm    │ │     │ │  3.3cm    │ │     │
│     │ │  × 2.1cm  │ │     │ │  × 2.1cm  │ │     │ │  × 2.1cm  │ │     │
│     │ │           │ │     │ │           │ │     │ │           │ │     │
│     │ └───────────┘ │     │ └───────────┘ │     │ └───────────┘ │     │
│     │                                                                 │
│     │                       ↕ 3mm Gap                                 │
│     │                                                                 │
│     │                   (Continues...)
└─────────────────────────────────────────────────────────────────┘
```

---

## Horizontal Measurements (Width)

| Element | Size | Notes |
|---------|------|-------|
| **Left Margin** | **3mm** | Space from paper edge |
| **Barcode Label** | **31.67mm** | Each label width |
| **Spacing** | **3mm** | Between each label |
| **Right Margin** | **3mm** | Space to paper edge |
| **Total** | **107mm** | Paper width |

### Calculation:
```
3mm + 31.67mm + 3mm + 31.67mm + 3mm + 31.67mm + 3mm = 107mm
```

---

## Vertical Measurements (Height)

| Element | Size | Notes |
|---------|------|-------|
| **Barcode Label** | **21mm (2.1cm)** | Each label height |
| **Row Gap** | **3mm** | Space between rows |
| **Continuous** | **∞** | Roll continues |

### Row Height Calculation:
```
21mm (label) + 3mm (gap) = 24mm per row
```

---

## Individual Label Breakdown

```
┌───────────────────────────────┐ 31.67mm Width
│  Padding: 2mm (horizontal)     │
│  1.5mm (vertical)              │
├───────────────────────────────┤
│                               │
│  Product Name                 │ 6.5pt font
│  (2 lines max)                │ ~4mm height
│                               │
├───────────────────────────────┤
│                               │
│  Rs 2,500.00                  │ 8.5pt font
│                               │ ~2mm height
│                               │
├───────────────────────────────┤
│                               │
│  [BARCODE IMAGE]              │ 9mm max height
│  ║║║║║║║║║║║║║║║║║           │ CODE-128
│                               │
├───────────────────────────────┤
│                               │
│  LPBT001                      │ 7pt monospace
│  (Product Code)               │ ~2mm height
│                               │
└───────────────────────────────┘ 21mm (2.1cm) Height
```

---

## Label Internal Structure

### Padding:
- **Top/Bottom:** 1.5mm each (3mm total vertical)
- **Left/Right:** 2mm each (4mm total horizontal)

### Content Spacing:
- **Product Name:** ~4mm height (2 lines × ~2mm)
- **Price:** ~2mm height
- **Barcode Image:** ~9mm height (max)
- **Product Code:** ~2mm height

### Label Content Height Breakdown:
```
1.5mm (top padding)
+ 4mm (product name)
+ 2mm (price)
+ 9mm (barcode)
+ 2mm (code)
+ 1.5mm (bottom padding)
= 20mm (approx, allowing for margins between elements)
```

---

## Grid Layout

### Per Row:
- **3 barcodes** side by side
- **2mm** spacing between each
- **2mm** margins on left and right

### Per Page (Continuous Roll):
- **Unlimited rows** (continuous)
- **3mm** gap between each row
- **21mm** label height per row
- **24mm** total height per row (21mm + 3mm gap)

---

## Print Specifications

### @page Settings:
```css
@page {
    size: 107mm auto;  /* Width: 107mm, Height: auto (continuous) */
    margin: 0;
    padding: 0;
}
```

### Example Output:
```
Row 1: [Label] [Label] [Label]
       (3mm gap)
Row 2: [Label] [Label] [Label]
       (3mm gap)
Row 3: [Label] [Label] [Label]
       (continues...)
```

---

## Examples

### 9 Barcodes Layout:
```
Row 1: Label 1 | Label 2 | Label 3  (3 barcodes)
       ↕ 3mm gap
Row 2: Label 4 | Label 5 | Label 6  (3 barcodes)
       ↕ 3mm gap
Row 3: Label 7 | Label 8 | Label 9  (3 barcodes)
```

**Total Height:** ~72mm (3 rows × 24mm)

### 1 Barcode Layout:
```
Row 1: Label 1 | [Empty] | [Empty]  (1 barcode, 2 empty slots)
```

**Total Height:** ~24mm (1 row)

### 5 Barcodes Layout:
```
Row 1: Label 1 | Label 2 | Label 3  (3 barcodes)
       ↕ 3mm gap
Row 2: Label 4 | Label 5 | [Empty]  (2 barcodes, 1 empty)
```

**Total Height:** ~48mm (2 rows)

---

## Technical Measurements Summary

| Measurement | Value | Unit |
|-------------|-------|------|
| Paper Width | 107 | mm |
| Paper Height | Auto | (Continuous) |
| Label Width | 31.67 | mm |
| Label Height | 21 | mm |
| Label Padding (H) | 2 | mm |
| Label Padding (V) | 1.5 | mm |
| Label Spacing | 3 | mm |
| Row Gap | 3 | mm |
| Left Margin | 3 | mm |
| Right Margin | 3 | mm |
| Labels per Row | 3 | count |
| Rows per Print | Unlimited | (Continuous roll) |

---

## Visual Spacing Reference

```
3mm│31.67mm│3mm│31.67mm│3mm│31.67mm│3mm = 107mm Total
 └──┘└──────┘└──┘└──────┘└──┘└──────┘└──┘
Label1    Label2    Label3
  ↕ 3mm gap (between rows)
Label4  Label5  Label6
```

---

## CSS Reference Values

```css
.barcode-container {
    width: 107mm;
}

.barcode-row {
    width: 107mm;
    margin-bottom: 3mm;  /* Gap between rows */
}

.barcode-label {
    width: 31.67mm;
    height: 21mm;  /* 2.1cm */
    padding: 1.5mm 2mm;  /* Vertical: 1.5mm, Horizontal: 2mm */
}

.barcode-spacer {
    width: 3mm;  /* Spacing between labels */
}
```

---

## Printer Settings Required

1. **Paper Size:** Custom 107mm × Auto
2. **Margins:** 0mm (None)
3. **Scale:** 100%
4. **Orientation:** Portrait
5. **Paper Type:** Continuous Roll (Thermal)
6. **Headers/Footers:** Disabled

---

**Last Updated:** 2025-10-19  
**System:** LAPTOP EXPERT Barcode Printing System


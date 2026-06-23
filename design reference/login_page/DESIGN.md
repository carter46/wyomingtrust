---
name: Heritage Modern
colors:
  surface: '#f8f9fa'
  surface-dim: '#d9dadb'
  surface-bright: '#f8f9fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f4f5'
  surface-container: '#edeeef'
  surface-container-high: '#e7e8e9'
  surface-container-highest: '#e1e3e4'
  on-surface: '#191c1d'
  on-surface-variant: '#44474c'
  inverse-surface: '#2e3132'
  inverse-on-surface: '#f0f1f2'
  outline: '#74777d'
  outline-variant: '#c4c6cd'
  surface-tint: '#4f6073'
  primary: '#041627'
  on-primary: '#ffffff'
  primary-container: '#1a2b3c'
  on-primary-container: '#8192a7'
  inverse-primary: '#b7c8de'
  secondary: '#115cb9'
  on-secondary: '#ffffff'
  secondary-container: '#659dfe'
  on-secondary-container: '#003370'
  tertiary: '#081812'
  on-tertiary: '#ffffff'
  tertiary-container: '#1d2d25'
  on-tertiary-container: '#83958b'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d2e4fb'
  primary-fixed-dim: '#b7c8de'
  on-primary-fixed: '#0b1d2d'
  on-primary-fixed-variant: '#38485a'
  secondary-fixed: '#d7e2ff'
  secondary-fixed-dim: '#acc7ff'
  on-secondary-fixed: '#001a40'
  on-secondary-fixed-variant: '#004491'
  tertiary-fixed: '#d4e7db'
  tertiary-fixed-dim: '#b8cbc0'
  on-tertiary-fixed: '#0f1f18'
  on-tertiary-fixed-variant: '#3a4a42'
  background: '#f8f9fa'
  on-background: '#191c1d'
  surface-variant: '#e1e3e4'
  warm-cream: '#FEFDF3'
  sky-accent: '#B6D6F2'
  deep-forest: '#2D4B3F'
  plum-shadow: '#341B2F'
typography:
  display-lg:
    fontFamily: Source Serif 4
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Source Serif 4
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Source Serif 4
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
  headline-md:
    fontFamily: Source Serif 4
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: DM Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: DM Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: DM Sans
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: DM Sans
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  container-max: 1200px
  gutter: 24px
  margin-mobile: 16px
  section-padding-lg: 80px
  section-padding-md: 48px
  stack-gap: 16px
---

## Brand & Style

This design system establishes a visual language of **enduring trust, security, and warmth**. It is designed to bridge the gap between traditional legal authority and modern digital accessibility, catering to families and individuals seeking peace of mind through estate planning.

The design style is **Modern Corporate with a Tactile touch**. It utilizes generous whitespace and a structured grid to convey organization, while soft shadows and rounded corners ensure the interface feels approachable rather than clinical. The visual narrative is "protection for the modern age," balancing high-contrast typography with a calming, sophisticated palette that avoids the aggressive aesthetics of typical fintech.

## Colors

The palette is rooted in **Deep Navy (#1A2B3C)**, used for primary headings and navigation to establish a foundation of stability and professional heritage. **Trustworthy Blue (#0056B3)** serves as the primary action color, providing a clear but calm signal for progress and calls to action.

To soften the interface, we utilize **Soft Sage (#7A8C82)** and a **Warm Cream (#FEFDF3)** for secondary sections and background variations. This subtle shift in background temperature helps distinguish content blocks without the need for heavy dividers. **Sky Accent (#B6D6F2)** is reserved for light card backgrounds or subtle hover states, maintaining a sense of openness and "breathing room" across the experience.

## Typography

The typographic strategy pairs **Source Serif 4** with **DM Sans** to create a "Heritage Modern" feel. 

- **Headlines:** Use Source Serif 4 for all display and section headers. The high x-height and sturdy serifs convey authority and history, essential for a legal and trust-based platform.
- **Body & UI:** DM Sans provides a clean, geometric counterpoint. Its low-contrast and neutral character ensure that long-form legal explanations remain highly legible and stress-free.
- **Labels:** Small labels and captions use DM Sans with increased letter spacing and a medium-to-bold weight to ensure hierarchy is maintained even at small scales.

## Layout & Spacing

The design system utilizes a **12-column fixed grid** for desktop, centered within a maximum width of 1200px. This constraint ensures that line lengths for body copy remain readable and professional.

Content is organized into **distinct vertical blocks**. We use a "rhythmic breath" approach where major sections are separated by 80px of vertical padding. On mobile, this scales down to 48px. 

To define sections without visual clutter:
1. **Background Alternation:** Switching from White (#FFFFFF) to Light Grey (#F8F9FA) or Warm Cream (#FEFDF3).
2. **Internal Padding:** Cards and containers use a consistent 24px or 32px internal padding to maintain a feeling of premium space.

## Elevation & Depth

Hierarchy is established through **Tonal Layers** and **Ambient Shadows**. Instead of heavy borders, the system relies on subtle depth to indicate interactivity and importance.

- **Level 0 (Base):** The primary background, flat and neutral.
- **Level 1 (Cards/Surface):** Used for informational blocks. Features a very soft, diffused shadow (15% opacity Primary Color, 20px blur) and no border, or a 1px border in a slightly darker neutral shade.
- **Level 2 (Interactive):** Hover states for buttons and cards. The shadow intensifies slightly (increase blur and spread) to suggest the element is lifting toward the user.
- **Glassmorphism:** Reserved specifically for mobile navigation overlays or "sticky" floating action buttons, using a light backdrop blur (12px) to maintain context of the page behind the element.

## Shapes

The shape language is **Rounded**, designed to feel friendly and safe. 

- **Standard Radius:** 0.5rem (8px) is applied to most UI components, including input fields and small cards.
- **Large Radius:** 1rem (16px) is used for large content containers and hero imagery to create a softer, more modern framing.
- **Pill Shapes:** Reserved exclusively for tags and specific secondary buttons to differentiate them from the primary rectangular action buttons.

## Components

### Buttons
- **Primary:** Solid Trustworthy Blue (#0056B3) with White text. 8px rounded corners. Includes a trailing arrow icon (→) for directional clarity.
- **Secondary:** Ghost style with a 2px border of Deep Navy or a light fill of Sky Accent.
- **Tertiary:** Text-only with an underline on hover, used for "Learn More" or "Read Reviews" within cards.

### Cards
Cards are the primary vehicle for the "Nice Sections" requirement. They should feature 16px rounded corners, a Level 1 shadow, and generous internal padding (32px). When grouped (e.g., Will vs. Trust), cards should use subtle background color shifts to indicate the "popular" or "recommended" choice.

### Inputs & Forms
Form fields use a Light Grey (#F8F9FA) fill with a subtle bottom border that transforms into a full primary-colored stroke on focus. This reduces visual noise in complex legal forms.

### Lists
Use custom checkmark icons in Soft Sage (#7A8C82) for feature lists to reinforce the "security" and "completion" aspect of the service.

### Imagery
Photography should be high-resolution with a warm, natural grade. Focus on candid moments of family security—intergenerational interactions and quiet moments of planning. Avoid overly staged "business" stock; aim for lifestyle authenticity.
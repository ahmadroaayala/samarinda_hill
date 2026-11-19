import {
  ArrowLeft,
  ArrowRight,
  ChevronDown,
  ChevronLeft,
  ChevronRight,
  Component,
  Cpu,
  createIcons,
  Download,
  ExternalLink,
  Eye,
  FileText,
  Lightbulb,
  List,
  Menu,
  MousePointerClick,
  Phone,
  UserGroup,
  X,
} from "lucide";
import Alpine from "alpinejs";

const initLucideIcons = () => {
  createIcons({
    icons: {
      // common
      ArrowRight,
      ArrowLeft,
      ChevronDown,
      ChevronLeft,
      ChevronRight,
      ExternalLink,
      Menu,
      X,
      Lightbulb,
      Phone,
      FileText,
    },
  });
};

window.initLucideIcons = initLucideIcons;

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
  initLucideIcons();
});

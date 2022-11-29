import { Topbar } from "./Topbar";

export interface TopbarConfig {
  autoRun?: boolean;
  barThickness?: number;
  barColors?: {
    [key: string]: string;
  };
  shadowBlur?: number;
  shadowColor?: string;
  className?: string;
}

export const topbarConfig: TopbarConfig = {
  barColors: {
    0: "#86b7fe",
    ".3": "#3d8bfd",
    "1.0": "#0d6efd",
  },
};

export const $topbar = new Topbar();

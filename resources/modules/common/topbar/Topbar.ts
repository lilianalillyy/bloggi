// @ts-ignore
import topbar from "topbar";
import { topbarConfig, TopbarConfig } from ".";

export class Topbar {
  constructor(config: Partial<TopbarConfig> = {}) {
    // Load the default configuration
    this.config({
      ...topbarConfig,
      ...config,
    })
  }

  private config(settings: TopbarConfig): void {
    return topbar.config(settings);
  }

  /**
   * Show the topbar
   */
  show(): void {
    return topbar.show();
  }

  /**
   * Hide the topbar
   */
  hide(): void {
    return topbar.hide();
  }

  /**
   * Progress
   *
   * Returns the topbar progress status.
   * Additionally, the status can be changed by passing a number
   * (or a string that can be casted to a number) to the "to" parameter.
   *
   * @param {string | number} to Set progress status
   */
  progress(to?: string | number): number {
    return topbar.progress(to);
  }

  /**
   * Promised Topbar
   *
   * This is useful for eg. data fetching,
   * when this function is called, the topbar appears and
   * hides upon resolving of the promise passed in the "promise" parameter.
   *
   * @param {Promise<any>} promise Promise to toggle Topbar upon
   */
  promised<TPromise extends Promise<unknown> = Promise<unknown>>(
    promise: TPromise
  ): TPromise {
    this.show();
    promise.then(this.hide);
    promise.catch(this.hide);
    return promise;
  }
}
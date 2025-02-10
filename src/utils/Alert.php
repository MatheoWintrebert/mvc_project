<?php
declare(strict_types=1);

class Alert {
  private string $message;
  /** @property "success" | "info" | "warning" | "danger" $className */
  private string $className;

  public function __construct(string $message, string $className) {
    $this->message = $message;
    $this->className = $className;
  }

  public function getMessage(): string {
    return $this->message;
  }

  public function getClassName(): string {
    return $this->className;
  }

  public function setMessage(string $message): Alert {
    $alert = new Alert(message: $message, className: $this->className);
    self::save(alert: $alert);
    return $alert;
  }

  public function setClassName(string $className): Alert {
    $alert = new Alert(message: $this->message, className: $className);
    self::save(alert: $alert);
    return $alert;
  }

  public function render(): string {
    return '<div class="alert alert-'.$this->className.'" role="alert">'.$this->message.'</div>';
  }
  public static function save(Alert $alert): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION["alert"] = $alert;
  }

  public static function getFromSession(): ?Alert {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return $_SESSION["alert"] ?? null;
  }

  public static function clear(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    unset($_SESSION["alert"]);
  }
}
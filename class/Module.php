<?php

declare(strict_types=1);

class Module
{
    public function __construct(
        private ?int $id,
        private int $deviceId,
        private string $name,
        private string $description,
        private string $command,
        private ?\DateTimeImmutable $lastExecuted,
        private string $status
    ) {}

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceId(): int
    {
        return $this->deviceId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getLastExecuted(): ?\DateTimeImmutable
    {
        return $this->lastExecuted;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // Setters
    public function setDeviceId(int $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    public function setLastExecuted(?\DateTimeImmutable $lastExecuted): void
    {
        $this->lastExecuted = $lastExecuted;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    // Hydrate from DB row
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            deviceId: (int) $data['device_id'],
            name: (string) $data['name'],
            description: (string) $data['description'],
            command: (string) $data['command'],
            lastExecuted: isset($data['last_executed']) ? new \DateTimeImmutable($data['last_executed']) : null,
            status: (string) $data['status']
        );
    }

    // Export for DB insert/update
    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'device_id'     => $this->deviceId,
            'name'          => $this->name,
            'description'   => $this->description,
            'command'       => $this->command,
            'last_executed' => $this->lastExecuted?->format('Y-m-d H:i:s'),
            'status'        => $this->status,
        ];
    }
}

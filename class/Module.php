<?php

declare(strict_types=1);

class Module
{
    public int $id;
    public int $deviceId;
    public string $name;
    public string $description;
    public string $command;
    public DateTime $lastExecuted;
    public string $status;

    public function __construct(
        int $id,
        int $deviceId,
        string $name,
        string $description,
        string $command,
        DateTime $lastExecuted,
        string $status
    ) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->name = $name;
        $this->description = $description;
        $this->command = $command;
        $this->lastExecuted = $lastExecuted;
        $this->status = $status;
    }

    // Hydrate from DB row
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            deviceId: (int) $data['device_id'],
            name: (string) $data['name'],
            description: (string) $data['description'],
            command: (string) $data['command'],
            lastExecuted: !empty($data['last_executed'])
                ? new DateTime($data['last_executed'])
                : new DateTime(),
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

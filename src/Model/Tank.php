<?php
namespace App\Model;

use App\Service\Config;

class Tank
{
    private ?int $id = null;
    private ?string $make = null;
    private ?string $model = null;
    private ?int $year = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Tank
    {
        $this->id = $id;

        return $this;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(?string $make): Tank
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): Tank
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int {
        return $this->year;
    }

    public function setYear(?int $year) : Tank {
        $this->year = $year;
        return $this;
    }

    public static function fromArray($array): Tank
    {
        $Tank = new self();
        $Tank->fill($array);

        return $Tank;
    }

    public function fill($array): Tank
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['make'])) {
            $this->setMake($array['make']);
        }
        if (isset($array['model'])) {
            $this->setModel($array['model']);
        }
        if (isset($array['year'])) {
            $this->setYear($array['year']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM tanks';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $posts = [];
        $postsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function find($id): ?Tank
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM tanks WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $postArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $Tanks = Tank::fromArray($postArray);

        return $Tanks;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO tanks (make, model, year) VALUES (:make, :model, :year)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'make' => $this->getMake(),
                'model' => $this->getModel(),
                'year' => $this->getYear(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE tanks SET make = :make, model = :model, year = :year WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':make' => $this->getMake(),
                ':model' => $this->getModel(),
                ':year' => $this->getYear(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM tanks WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setMake(null);
        $this->setModel(null);
        $this->setYear(null);
    }
}

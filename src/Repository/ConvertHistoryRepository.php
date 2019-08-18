<?php

namespace App\Repository;

use App\Entity\ConvertHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConvertHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConvertHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConvertHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvertHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConvertHistory::class);
    }


    public function findAll()
    {
        return $this->findBy([], ['date' => 'desc']);
    }

    public function save($currencyFrom, $amountFrom, $currencyTo, $amountTo, string $capital = '', string $country = '', \DateTimeInterface $date = null)
    {
        if (empty($date)) {
            $date = new \DateTime;
        }

        if ($exists = $this->findByDate($currencyFrom, $amountFrom, $currencyTo, $date, $capital, $country)) {
            return $exists;
        }

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getEntityManager();

        $product = new ConvertHistory();
        $product->setCurrencyFrom($currencyFrom);
        $product->setAmountFrom($amountFrom);
        $product->setCurrencyTo($currencyTo);
        $product->setAmountTo($amountTo);
        $product->setCapital($capital);
        $product->setCountry($country);
        $product->setDate($date);

        $entityManager->persist($product);

        $entityManager->flush();

        return $product;
    }

    public function findByDate($currencyFrom, $amountFrom, $currencyTo, \DateTimeInterface $date, string $capital = '', string $country = '')
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.date = :date')
            ->andWhere('c.currency_from = :currency_from')
            ->andWhere('c.currency_to = :currency_to')
            ->andWhere('c.amount_from = :amount_from')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('currency_from', $currencyFrom)
            ->setParameter('currency_to', $currencyTo)
            ->setParameter('amount_from', $amountFrom);

        if (!empty($capital)) {
            $query->andWhere('c.capital = :capital')
                ->setParameter('capital', $capital);
        }

        if (!empty($country)) {
            $query->andWhere('c.country = :country')
                ->setParameter('country', $country);
        }

        return $query->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return ConvertHistory[] Returns an array of ConvertHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConvertHistory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

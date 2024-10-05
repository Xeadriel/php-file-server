<?php

namespace App\Repository;

use App\Entity\WikiPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WikiPage>
 */
class WikiPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WikiPage::class);
    }

/**
 * saves new wikipage or overwrites existing one 
 * depending on whether id already exists
 * returns wikipage with given id
 */
public function saveWikipage(WikiPage $wikipage): WikiPage
    {
        $this->getEntityManager()->persist($wikipage);
        $this->getEntityManager()->flush();

		return $wikipage;
    }

/**
 * returns wikipage with given id or null if not found
 */
public function findPageById($id): ?WikiPage
	{
		return $this->createQueryBuilder('w')
			->andWhere('w.id = :val')
			->setParameter('val', $id)
			->getQuery()
			->setMaxResults(1)
			->getOneOrNullResult()
		;
	}

/**
 * returns all wikipages with given category or null if not found
 */
public function findPagesByCategory($category): ?array
	{
		return $this->createQueryBuilder('w')
			->andWhere('w.category = :val')
			->setParameter('val', $category)
			->getQuery()
			->getResult()
		;
	}
}

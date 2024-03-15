package com.highcharts.export.pool;

import java.util.Queue;
import java.util.concurrent.atomic.AtomicInteger;

import org.apache.log4j.Logger;
import org.springframework.scheduling.annotation.Scheduled;

/**
 * AbstractPool is an abstract class that implements the ObjectPool interface.
 * It provides a basic framework for managing a pool of objects, including creating,
 * destroying, borrowing, and returning objects. The class also includes a pool cleaning
 * mechanism that runs every minute to remove invalid objects from the pool.
 */
public abstract class AbstractPool<T> implements ObjectPool<T> {

	final ObjectFactory<T> objectFactory; // ObjectFactory to create and destroy objects
	Queue<T> queue; // Queue to hold the objects in the pool
	final AtomicInteger poolSize = new AtomicInteger(0); // AtomicInteger to keep track of the number of objects in the pool
	int maxWait; // Maximum time to wait for an object to become available
	final int capacity; // Maximum capacity of the pool
	protected static Logger logger = Logger.getLogger("pool"); // Logger for debugging and logging

	/**
	 * Constructor for AbstractPool that takes an ObjectFactory, number of objects, and max wait time.
	 *
	 * @param objectFactory ObjectFactory to create and destroy objects
	 * @param number Maximum number of objects in the pool
	 * @param maxWait Maximum time to wait for an object to become available
	 * @throws PoolException If there is an error creating the pool
	 */
	public AbstractPool(ObjectFactory<T> objectFactory, int number, int maxWait) throws PoolException {
		this.objectFactory = objectFactory;
		this.capacity = number;
		this.maxWait = maxWait;
	}

	/**
	 * Creates a new object and adds it to the pool.
	 */
	@Override
	public void createObject() {
		T object = objectFactory.create();
		queue.add(object);
		poolSize.getAndIncrement();
	}

	/**
	 * Destroys an object and removes it from the pool.
	 *
	 * @param object Object to destroy and remove from the pool
	 */
	@Override
	public void destroyObject(T object) {
		objectFactory.destroy(object);
	}

	/**
	 * Cleans the pool by removing invalid objects and adjusting the pool size as necessary.
	 * This method is scheduled to run every minute.
	 *
	 * @throws InterruptedException If the thread is interrupted
	 * @throws PoolException If there is an error cleaning the pool
	 */
	@Override
	@Scheduled(initialDelay = 10000, fixedRate = 60000)
	public void poolCleaner() throws InterruptedException, PoolException {

		logger.debug("HC: queue size: " + queue.size() + " poolSize " + poolSize.get());

		int size = poolSize.get();
		// remove invalid objects
		for (int i = 0; i < size; i++) {
			T object = borrowObject();
			if (object == null) {
				logger.debug("HC: object is null");
				continue;
			} else {
				logger.debug("HC: validating " + object.toString());
				if (!objectFactory.validate(object))
